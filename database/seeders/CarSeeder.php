<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 3 car

        DB::table('cars')->insert([
            // carName
            'carName' => 'Toyota',
            // carModel
            'carModel' => 'Vios',
            // Transmission
            'Transmission' => 'automatic',
            // carYear
            'carYear' => '2019',
            // carColor
            'carColor' => 'White',
            // carPlateNumber
            'carPlateNumber' => 'ABC123',
            // carImage
            'carImage' => 'https://www.toyota.com.my/ToyotaOfficialWebsite/media/ToyotaMedia/model/Vios%202019/white.png',
            // carStatus
            'carStatus' => 'available',

        ]);
    }
}
