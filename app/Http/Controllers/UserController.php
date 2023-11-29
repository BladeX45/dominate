<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Hash;
// use send email
use Illuminate\Support\Facades\Mail;
// use verify email
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Validator; // Import the Validator class


class UserController extends Controller
{

    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    // Register Account by Admin
    public function registerUser(Request $request)
    {
        // dd($request->all());
        // check request RequestRole = RoleID
        if($request->role == 'admin'){
            $request->role = 1;
        }else if($request->role == 'customer'){
            $request->role = 2;
        }else if($request->role == 'Instructor'){
            $request->role = 3;

            // create user
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'roleID' => $request->role,
                'email' => $request->email,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),
                'remember_token'=> '',
            ]);

            // update
            $user = User::find($user->id);
            $user->email_verified_at = now();
            $user->save();

            // create instructor with zero valu
            $instructor = Instructor::create([
                // firstName
                'firstName' => '',
                // lastName
                'lastName' => '',
                // gender
                'gender' => 'other',
                // nin
                'NIN' => '',
                // birthDate
                'birthDate' => now(),
                // address
                'address' => '',
                // phone
                'phone' => '',
                // drivingExperience
                'drivingExperience' => 0,
                // certificate
                'certificate' => '',
                // rating
                'rating' => 0,
                // userID
                'userID' => $user->id,
            ]);

            // return
            return redirect()->back()->with('status', __('User successfully created.'));
        }else{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:8',
                'firstName' => 'required_if:role,customer|string|max:255',
                'lastName' => 'required_if:role,customer|string|max:255',
                'NIN' => 'required_if:role,customer|string|max:255',
                'birthDate' => 'required_if:role,customer|date',
                'phone' => 'required_if:role,customer|string|max:255',
                'gender' => ['required_if:role,customer', Rule::in(['male', 'female', 'other'])],

            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = User::create([
                'name' => $request->name,
                'roleID' => 2,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                // email_verified_at
                'email_verified_at' => now(),
                // remember_token
                // 'remember_token' => '',
            ]);

            // dd($user);
            // dd($user->id);
            // create customer
            $customer = Customer::create([
                'userID' => $user->id,
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'NIN' => $request->NIN,
                'birthDate' => $request->birthDate,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'address' => $request->address,
                // 'remember_token' => '',
            ]);

            // auth attempt
            Auth::attempt($request->only('email', 'password'));

            $user = User::find($user->id);
            // send email verification
            $user->sendEmailVerificationNotification();
            //    send email verifikasi
            return redirect()->route('verification.send')->with('status', __('User successfully created.'));
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'roleID' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);





        return redirect()->back()->with('status', __('User successfully created.'));

    }
}
