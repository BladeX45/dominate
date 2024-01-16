<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    // login Controller
    public function login(Request $request) {
        // Validate the login request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in the user
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Check if the user's account is verified
            if (!$user->email_verified_at) {
                // Send an email for email verification and then redirect
                // You may want to implement this part separately
                // return redirect()->route('verification.send')->with('error', 'Your account is not verified!');
                // For now, I'm just returning an error message
                return redirect()->route('verification.send')->with('error', 'Your account is not verified!');
            }

            dd($user->roleID);

            // Redirect based on the user's role
            switch ($user->roleID) {
                case 1:
                    return redirect()->route('admin.dashboard');
                case 2:
                    return redirect()->route('customer.dashboard');
                case 3:
                    return redirect()->route('instructor.dashboard');
                default:
                    return redirect()->route('welcome');
            }
        }

        // Authentication failed, redirect with an error message
        return redirect()->route('login')->with('error', 'Email or Password is wrong!');
    }


    /*
            'email' => 'admin@black.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'roleID' => 1,
            'created_at' => now(),
            'updated_at' => now()
    */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // login
    public function showLoginForm()
    {
        return view('auth.login');
    }

}
