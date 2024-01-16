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
        // Konversi peran ke ID peran yang sesuai
        $roleId = $this->getRoleIdFromRoleName($request->role);

        if ($roleId === null) {
            // Jika peran tidak valid, tampilkan pesan kesalahan
            return redirect()->back()->with('error', __('Invalid role specified.'));
        }

        // Buat pengguna
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'roleID' => $roleId,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        // checl email exist
        $checkEmail = User::where('email', $request->email)->first();

        if ($checkEmail) {
            return redirect()->back()->with('error', __('Email already exist.'));
        }

        if ($roleId === 3) {
            // Jika peran adalah "Instructor," tambahkan detail instruktur
            $instructor = Instructor::create([
                'firstName' => '',
                'lastName' => '',
                'gender' => 'other',
                'NIN' => '',
                'birthDate' => now(),
                'address' => '',
                'phone' => '',
                'drivingExperience' => 0,
                'certificate' => '',
                'rating' => 0,
                'userID' => $user->id,
            ]);
        } elseif ($roleId === 2) {
            // Jika peran adalah "Customer," tambahkan detail pelanggan
            $validator = Validator::make($request->all(), [
                'firstName' => 'required_if:role,customer|string|max:255',
                'lastName' => 'required_if:role,customer|string|max:255',
                'NIN' => 'required_if:role,customer|string|max:255',
                'birthDate' => 'required_if:role,customer|date',
                'address' => 'required_if:role,customer|string|max:255',
                'phone' => 'required_if:role,customer|string|max:255',
                'gender' => ['required_if:role,customer', Rule::in(['male', 'female', 'other'])],
            ]);

            if ($validator->fails()) {
                // delete user
                $user->delete();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $customer = Customer::create([
                'userID' => $user->id,
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'NIN' => $request->NIN,
                'birthDate' => $request->birthDate,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'address' => $request->address,
            ]);

            // Coba otentikasi pengguna baru
            Auth::attempt($request->only('email', 'password'));

            // Kirim email verifikasi
            $user = User::find($user->id);
            $user->sendEmailVerificationNotification();

            // Redirect ke halaman pengiriman verifikasi email
            return redirect()->route('verification.send')->with('status', __('User successfully created.'));
        }

        // Redirect kembali dengan pesan sukses jika tidak ada kesalahan
        return redirect()->back()->with('status', __('User successfully created.'));
    }

    // Fungsi bantu untuk mendapatkan ID peran dari nama peran
    private function getRoleIdFromRoleName($roleName)
    {
        switch ($roleName) {
            case 'admin':
                return 1;
            case 'customer':
                return 2;
            case 'Instructor':
                return 3;
            default:
                return null; // Kembalikan null jika peran tidak valid
        }
    }

}
