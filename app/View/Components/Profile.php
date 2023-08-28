<?php

namespace App\View\Components;

use App\Models\User;
use App\Models\Customer;
use App\Models\Instructor;
use Illuminate\View\Component;

class Profile extends Component
{
    public $userData;
    public $profileData;

    public function __construct($idUser)
    {
        $this->userData = User::find($idUser);

        if ($this->userData['roleID'] == '3') {
            // dd($idUser);
            $this->profileData = Instructor::where('userID', $idUser)->get();
        } else if ($this->userData['roleID'] == '2') {
            $this->profileData = Customer::where('userID', $idUser)->get();
        }
    }

    public function render()
    {
        return view('components.profile');
    }
}
