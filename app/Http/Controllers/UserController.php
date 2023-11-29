<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Instructor;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
// use send email
use Illuminate\Support\Facades\Hash;
// use verify email
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
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

            // validate user
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'firstName' => 'required_if:role,customer|string|max:255',
                'lastName' => 'required_if:role,customer|string|max:255',
                'NIN' => 'required_if:role,customer|string|max:255',
                'birthDate' => 'required_if:role,customer|date',
                'address' => 'required_if:role,customer|string|max:255',
                'phone' => 'required|string', // Assuming phone is a string
                'gender' => 'required|in:female,male,other', // Assuming gender can only be one of these values
            ]);

            // Now, check if the validation fails
            if ($validator->fails()) {
                // Handle validation errors
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // If validation passes, you can access the validated data like this:
            $data = $validator->validated();

            // create user
            $user = User::create([
                'name' => $request->name,
                'roleID' => $request->role,
                'email' => $request->email,
                'password' => Hash::make($request->birthDate),
                'avatar' => '',
            ]);

            // email verified at
            $user->email_verified_at = now();
            $user->save();

            // Assuming you have already validated the request and created the User record

            // try to create customer
            try{
                $customer = customer::create([
                    'userID' => $user->id, // Assuming your Instructor model has a foreign key 'user_id'
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'NIN' => $request->NIN,
                    'birthDate' => $request->birthDate,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                ]);

                return redirect()->route('admin.customers'); // Replace 'your.route.name' with the actual route name you want to redirect to
            }
            catch(\Exception $e){
                // If an error occurs, delete the User record
                $user->delete();

                // Handle the exception
                return redirect()->back()->withErrors($e->getMessage())->withInput();
            }
        }else if($request->role == 'Instructor'){
            $request->role = 3;

            // dd($request->all());

            // validate user
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'certificate' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'firstName' => 'required_if:role,instructor|string|max:255',
                'lastName' => 'required_if:role,instructor|string|max:255',
                'NIN' => 'required_if:role,instructor|string|max:255',
                'birthDate' => 'required_if:role,instructor|date',
                'address' => 'required_if:role,instructor|string|max:255',
                'phone' => 'required|string', // Assuming phone is a string
                'drivingExperience' => 'required|numeric', // Assuming drivingExperience is a numeric value
                'gender' => 'required|in:female,male,other', // Assuming gender can only be one of these values
            ]);

            // Now, check if the validation fails
            if ($validator->fails()) {
                // Handle validation errors
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // If validation passes, you can access the validated data like this:
            $data = $validator->validated();

            // Use $data to save or update the user in your database

            // create user
            $user = User::create([
                'name' => $request->name,
                'roleID' => $request->role,
                'email' => $request->email,
                'password' => Hash::make($request->birthDate),
                'avatar' => '',
            ]);

            // email verified at
            $user->email_verified_at = now();
            $user->save();
            // Assuming you have already validated the request and created the User record

            // Upload the certificate file
            $imageName = time().'.'.$request->certificate->extension();
            // storeAs method is used to specify the directory, filename, and disk ('public' in this case)
            $request->certificate->storeAs('certificates', $imageName, 'public');

            // try to create instructor
            try{
                // Create the associated Instructor record
                $instructor = Instructor::create([
                    'userID' => $user->id, // Assuming your Instructor model has a foreign key 'user_id'
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'NIN' => $request->NIN,
                    'birthDate' => $request->birthDate,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'drivingExperience' => $request->drivingExperience,
                    'gender' => $request->gender,
                    'rating' => 0,
                    'certificate' => $imageName, // Assuming 'certificate' is the column where you store the file name
                ]);

                return redirect()->route('admin.users'); // Replace 'your.route.name' with the actual route name you want to redirect to
            }
            catch(\Exception $e){
                // If an error occurs, delete the User record
                $user->delete();

                // Delete the uploaded file
                Storage::disk('public')->delete('certificates/'.$imageName);

                // Handle the exception
                return redirect()->back()->withErrors($e->getMessage())->withInput();
            }


            // Additional actions if needed

            // Redirect or respond as needed
            return redirect()->route('admin.users'); // Replace 'your.route.name' with the actual route name you want to redirect to

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
