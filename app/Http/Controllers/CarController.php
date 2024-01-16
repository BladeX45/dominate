<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CarController extends Controller
{
    public function updateCar(Request $request)
    {

        // Cari mobil yang akan diupdate berdasarkan nama
        $car = Car::where('id', $request->id)->first();

        $imageName = ''; // Initialize the $imageName variable

        // Validasi gambar mobil jika ada
        if ($request->hasFile('carImage')) {
            $validator = $request->validate([
                'carImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Jika validasi berhasil, lakukan pengolahan gambar
            if ($validator) {
                // Hapus gambar lama jika ada
                $oldImage = $car->carImage;
                $oldImagePath = public_path('storage/cars/' . $oldImage);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Upload gambar baru
                $image = $request->file('carImage');
                $imageName = time() . '.' . $image->extension();
                $image->storeAs('public/cars', $imageName);
                $car->carImage = $imageName;
            }
        } else {

            // Jika tidak ada gambar baru, gunakan gambar lama
            if($car->carImage != ''){
                $imageName = $car->carImage;
            }
            else{
                $imageName = '';
            }
        }


        try{
            // Update data mobil
            $car = $car->update([
                'carName' => $request->carName,
                'carModel' => $request->carModel,
                'carYear' => $request->carYear,
                'carStatus' => $request->carStatus,
                'Transmission' => $request->Transmission,
                'carImage' => $imageName,
                'carColor' => $request->carColor,
                'carPlateNumber' => $request->carPlateNumber,
            ]);
        }
        catch(\Exception $e){
            return back()->withStatus(__('Car name already exists.'));
        }

        // Redirect kembali dengan pesan keberhasilan
        return back()->withStatus(__('Car successfully updated.'));
    }

public function store(Request $request)
{
    // Validasi input data
    $validatedData = $request->validate([
        'carName' => 'required|string',
        'carModel' => 'required|string',
        'Transmission' => 'required|string',
        'carYear' => 'required|string',
        'carStatus' => 'required|string',
        'carImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'carColor' => 'required|string',
        'carPlateNumber' => 'required|string',
    ]);

    // Inisialisasi variabel untuk nama gambar
    $imageName = '';

    // Periksa apakah gambar mobil diunggah
    if ($request->hasFile('carImage')) {
        $image = $request->file('carImage');

        // Generate nama unik berdasarkan timestamp
        $imageName = time() . '.' . $image->extension();

        // Simpan gambar ke direktori 'public/cars'
        $image->storeAs('public/cars', $imageName);
    }

    // Buat entitas Car baru dengan data yang telah divalidasi
    $car = new Car([
        'carName' => $validatedData['carName'],
        'carModel' => $validatedData['carModel'],
        'Transmission' => $validatedData['Transmission'],
        'carYear' => $validatedData['carYear'],
        'carStatus' => $validatedData['carStatus'],
        'carImage' => $imageName,
        'carColor' => $validatedData['carColor'],
        'carPlateNumber' => $validatedData['carPlateNumber'],
    ]);

    // Simpan data mobil ke database
    $car->save();

    // Redirect kembali dengan pesan keberhasilan
    return back()->withStatus(__('Car successfully added.'));
}



}
