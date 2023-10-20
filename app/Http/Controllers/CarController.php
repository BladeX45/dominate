<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    // setCarStatus
    public function updateCar(Request $request)
    {
        // data
        // "_method" => "put"
        // "_token" => "hHOzkSznM7gzv8h8LlQ9OId5i12ssnF4XcfdBGA9"
        // "carName" => "Handa"
        // "carModel" => "Jazz"
        // "Transmission" => "automatic"
        // "carYear" => "2019"
        // "carStatus" => "Available"
        // "carImage => "image.jpg"

        // update car
        $car = Car::where('carName', $request->carName)->first();
        // validator must img/jpg/png



        // if any image
        if ($request->hasFile('carImage')) {
            $validator = $request->validate([
                'carImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);


            // delete old image
            $oldImage = $car->carImage;
            $oldImage = public_path('storage/cars/' . $oldImage);
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }

            // upload new image
            $image = $request->file('carImage');
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/cars', $imageName);
            $car->carImage = 'cars/' . $imageName;
        }

        $car->update([
            'carName' => $request->carName,
            'carModel' => $request->carModel,
            'carYear' => $request->carYear,
            'carStatus' => $request->carStatus,
            'carImage' => $imageName,
        ]);

        return back()->withStatus(__('Car successfully updated.'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }
}
