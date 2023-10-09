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
    public function login(Request $request){
        // validate data request
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required|min:8'
        // ]);

        // check role
        $credentials = $request->only('email', 'password');



        // check email and password
        if(Auth::attempt($credentials)){
            // if not verified then destroy session
            if(!Auth::user()->email_verified_at){
                // send email for view verification.send
                return redirect()->route('verification.send')->with('error', 'Your account is not verified!');
            }
            // check role
            if(Auth::user()->roleID == 1){
                return redirect()->route('admin.dashboard');
            }else if(Auth::user()->roleID == 2){
                return redirect()->route('customer.dashboard');
            }else if(Auth::user()->roleID == 3){
                return redirect()->route('instructor.dashboard');
            }else{
                return redirect()->route('welcome');
            }
        }else{
            return redirect()->route('login')->with('error', 'Email or Password is wrong!');
        }
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
