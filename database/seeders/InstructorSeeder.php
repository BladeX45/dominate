<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 1 Instructure
        DB::table('instructors')->insert([
            // firstName
            'firstName' => 'instructor',
            // lastName
            'lastName' =>'seeder',
            // NIN
            'NIN'=> '323412323242',
            // gender Male
            'gender'    => 'Female',
            // birthDate format DD/MM/YYYY
            'birthDate' => '1989-01-01',
            // address
            'address'   => 'address',
            // phone
            'phone'     => '+39 845678901',
            // driving Experience
            'drivingExperience' => 10,
            // certificate
            'certificate' => 'asijdbuybqsjdnbasdhbasd',
            // rating
            'rating' => 4.5,
            // fk from user
            'userID' => 3,
        ]);
    }
}
