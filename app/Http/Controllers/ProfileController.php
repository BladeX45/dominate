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
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        // Simpan nama foto sebelumnya
        $previousAvatar = $user->avatar;

        if ($previousAvatar) {
            // Hapus foto sebelumnya dari penyimpanan
            Storage::disk('public')->delete('avatar/' . $previousAvatar);
        }

        $uploadedFile = $request->file('photo');
        $filename = uniqid() . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();

        // Simpan file baru di penyimpanan publik
        Storage::disk('public')->put('avatar/' . $filename, file_get_contents($uploadedFile));

        // Update atribut 'avatar' pada model User
        $user->avatar = $filename;
        $user->save();

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
