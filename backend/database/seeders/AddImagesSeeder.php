<?php

namespace Database\Seeders;

use App\Models\Images;
use App\Models\Years;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $years = Years::pluck('year_id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            $newImage = new Images();

            $newImage->image = 'image' . mt_rand(1, 100) . '.jpg';
            $newImage->year_id = $years[array_rand($years)];
            $newImage->save();
        }
    }
}
