<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create one customer
        DB::table('customers')->insert([
            // firstName
            'firstName' => 'customer',
            // lastName
            'lastName' =>'seeder',
            // gender Male
            'gender'    => 'Male',
            // NIN
            'nin'       => 123456789,
            // birthDate format DD/MM/YYYY
            'birthDate' => '2000-01-01',
            // address
            'address'   => 'address',
            // phone
            'phone'     => '+39 845678901',
            // total session -> default null
            'MaticSession' => 5,
            'ManualSession' => 10,
            // certificate -> default null
            'certificate' => null,
            // isCertificatePass -> default 0
            'isCertificatePass' => 0,
            // fk from user
            'userID' => 3,
        ]);
    }
}
