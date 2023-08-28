<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 4 Plans manual

        DB::table('plans')->insert([
            // planName
            'planName' => 'Basic',
            // planSession
            'planSession' => 7,
            // planType
            'planType' => 'manual',
            // planPrice
            'planPrice' => 250000,
            // planDescription
            'planDescription' => '7 sessions',
            // planStatus
            'planStatus' => 1,
        ]);
        DB::table('plans')->insert([
            // planName
            'planName' => 'Intermediate',
            // planSession
            'planSession' => 12,
            // planType
            'planType' => 'manual',
            // planPrice
            'planPrice' => 400000,
            // planDescription
            'planDescription' => '12 sessions',
            // planStatus
            'planStatus' => 1,
        ]);
        DB::table('plans')->insert([
            // planName
            'planName' => 'Advance',
            // planSession
            'planSession' => 15,
            // planType
            'planType' => 'manual',
            // planPrice
            'planPrice' => 500000,
            // planDescription
            'planDescription' => '15 sessions',
            // planStatus
            'planStatus' => 1,
        ]);
        DB::table('plans')->insert([
            // planName
            'planName' => '1 Session',
            // planSession
            'planSession' => 1,
            // planType
            'planType' => 'manual',
            // planPrice
            'planPrice' => 75000,
            // planDescription
            'planDescription' => '1 sessions',
            // planStatus
            'planStatus' => 1,
        ]);
        // create 4 Plans automatic
        DB::table('plans')->insert([
            // planName
            'planName' => 'Basic',
            // planSession
            'planSession' => 7,
            // planType
            'planType' => 'automatic',
            // planPrice
            'planPrice' => 250000,
            // planDescription
            'planDescription' => '7 sessions',
            // planStatus
            'planStatus' => 1,
        ]);
        DB::table('plans')->insert([
            // planName
            'planName' => 'Intermediate',
            // planSession
            'planSession' => 12,
            // planType
            'planType' => 'automatic',
            // planPrice
            'planPrice' => 400000,
            // planDescription
            'planDescription' => '12 sessions',
            // planStatus
            'planStatus' => 1,
        ]);
        DB::table('plans')->insert([
            // planName
            'planName' => 'Advance',
            // planSession
            'planSession' => 15,
            // planType
            'planType' => 'automatic',
            // planPrice
            'planPrice' => 500000,
            // planDescription
            'planDescription' => '15 sessions',
            // planStatus
            'planStatus' => 1,
        ]);
        DB::table('plans')->insert([
            // planName
            'planName' => '1 Session',
            // planSession
            'planSession' => 1,
            // planType
            'planType' => 'automatic',
            // planPrice
            'planPrice' => 75000,
            // planDescription
            'planDescription' => '1 sessions',
            // planStatus
            'planStatus' => 1,
        ]);
    }
}
