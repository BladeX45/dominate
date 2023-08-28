<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create role admin, customer, instructor

        // admin
        DB::table('roles')->insert([
            'roleID' => 1,
            'roleName' => 'admin',
            'roleDescription' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // customer
        DB::table('roles')->insert([
            'roleID' => 2,
            'roleName' => 'customer',
            'roleDescription' => 'customer',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // instructor
        DB::table('roles')->insert([
            'roleID' => 3,
            'roleName' => 'instructor',
            'roleDescription' => 'instructor',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // owner
        DB::table('roles')->insert([
            'roleID' => 0,
            'roleName' => 'owner',
            'roleDescription' => 'owner',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
