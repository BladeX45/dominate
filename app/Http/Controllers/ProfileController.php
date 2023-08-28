<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

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

        if ($request->hasFile('photo')) {
            $avatarPath = $request->file('photo');
            // Generate a unique hash to be used as the image name that will be stored in the storage directory
            $hashName = md5($avatarPath->getClientOriginalName()) . "." . $avatarPath->extension();

            // Upload avatar and resize it into various dimensions
            $uploadedAvatar = Image::make($avatarPath)->resize(300, 300);

            // Store the resized image in the public directory
            $publicPath = "public/assets/img/avatar/{$hashName}";
            Storage::put($publicPath, $uploadedAvatar->stream());

            $user->avatar = $hashName;
            $user->save();
        }

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
