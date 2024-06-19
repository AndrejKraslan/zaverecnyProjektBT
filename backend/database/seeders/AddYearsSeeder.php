<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Years;
use Illuminate\Support\Str;

class AddYearsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($year = 2020; $year <= 2025; $year++) {
            $newYear = new Years();
            $newYear->year = $year;
            $newYear->save();
        }
    }
}
