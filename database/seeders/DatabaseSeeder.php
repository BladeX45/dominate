<?php
namespace Database\Seeders;

use App\Models\instructors;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UsersTableSeeder::class,
            CustomerSeeder::class,
            instructorSeeder::class,
            CarSeeder::class,
            PlanSeeder::class,
            ScheduleSeeder::class
        ]);
    }
}
