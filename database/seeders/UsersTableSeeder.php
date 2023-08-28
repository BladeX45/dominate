<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // owner
        DB::table('users')->insert([
            'email' => 'owner@test.com',
            'name' => 'Owner',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            // avatar
            'avatar' => null,
            'roleID' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'email' => 'admin@black.com',
            'name' => 'crystallized',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            // avatar
            'avatar' => 'https://i.ibb.co/7tGKGvb/IMG-20201202-161751.jpg',
            'roleID' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // users for customer
        DB::table('users')->insert([
            'email' => 'customer1@test.com',
            'name' => 'customer1',
            'email_verified_at' => now(),
            'password' => Hash::make('customer1'),
            // avatar
            'avatar' => null,
            'roleID' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        // users for Instructor
        DB::table('users')->insert([
            'email' => 'instructor1@test.com',
            'name' => 'instructor1',
            'email_verified_at' => now(),
            'password' => Hash::make('instructor1'),
            'roleID' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);


    }
}
