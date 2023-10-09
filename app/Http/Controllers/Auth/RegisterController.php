<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    //  "name" => "B Tri Wibowo"
//   "email" => "190710235@students.uajy.ac.id"
//   "password" => "123123"
//   "password_confirmation" => "123123"
//   "firstName" => "adsasd"
//   "NIN" => "123123412341"
//   "birthDate" => "2023-09-19"
//   "phone" => "085155221292"
//   "lastName" => "asdasd"
//   "gender" => "male"
//   "address" => "asdasdasdas"
     protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'NIN' => ['required', 'string', 'max:255'],
            'birthDate' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:255'],
            // gender enum male, female, other
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'name' => ['string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // create customer
        $customer = Customer::create([
            'firstName' => $data['firstName'] ?? $data['email'],
            'lastName' => $data['lastName'] ?? $data['email'],
            'NIN' => $data['NIN'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'birthDate' => $data['birthDate'],
            'address' => $data['address'],
        ]);
        return User::create([
            'name' => $data['name'] ?? $data['email'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // verificationSend
    public function verificationSend(){
        return view('auth.verify');
    }

}
