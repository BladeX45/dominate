<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

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
        // check request RequestRole = RoleID
        if($request->role == 'admin'){
            $request->role = 1;
        }else if($request->role == 'customer'){
            $request->role = 2;
        }else if($request->role == 'Instructor'){
            $request->role = 3;
        }else{
            return redirect()->back()->with('status', __('Role not found.'));
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
