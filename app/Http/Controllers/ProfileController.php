<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use Intervention\Image\Facades\Image;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = User::find(auth()->user()->id);

        if ($user) {
            if ($user->roleID == 3) {
                // Update user
                $user->update($request->only(['name', 'email', 'password']));

                // Update instructor
                $instructor = Instructor::where('userID', auth()->user()->id)->first();
                $instructor->update($request->only(['firstName', 'lastName', 'NIN', 'birthDate', 'gender', 'drivingExperience', 'phone', 'address']));

                return back()->withStatus(__('Profile successfully updated.'));
            } elseif ($user->roleID == 2) {
                // Update user
                $user->update($request->only(['name', 'email', 'password']));

                // Update customer
                $customer = Customer::where('userID', auth()->user()->id)->first();
                $customer->update($request->only(['firstName', 'lastName', 'NIN', 'birthDate', 'gender', 'phoneNumber', 'address']));

                return back()->withStatus(__('Profile successfully updated.'));
            }
        }

        return back()->withStatus(__('Profile successfully updated.'));
    }


    public function updatePhoto(Request $request)
    {
        // Validasi request
        // dd($request);
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Atur validasi sesuai kebutuhan
        ]);

        // Dapatkan user yang sedang login
        $user = auth()->user();

        // Cek apakah user memiliki foto sebelumnya, dan hapus jika ada
        if ($user->avatar) {
            // Hapus foto sebelumnya dari direktori
            // Storage::disk('public')->delete('path/to/previous/avatar.jpg');

            // Hapus informasi foto dari basis data
            $user->avatar = null;
            $user->save();
        }

        // Get the uploaded file
        $uploadedFile = $request->file('photo');

        // Generate a unique filename for the uploaded file
        $filename = uniqid() . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();

        // move upload file to public/assets/img/receipt/..
        $uploadedFile->storeAs('avatar', $filename, 'public');

        // update
        $user = User::find(auth()->user()->id);
        // dd($user);
        $user->avatar = $filename;
        $user->save();

        // You would typically associate this with the user's record or the transaction record

        return redirect()->back()->with('success', 'Foto profil berhasil diunggah.');
    }



    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }


}
