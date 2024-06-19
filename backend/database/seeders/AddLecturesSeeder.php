<?php

namespace Database\Seeders;

use App\Models\Lectures;
use App\Models\Speakers;
use App\Models\Stages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddLecturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $speakers = Speakers::pluck('speaker_id')->toArray();
        $stages = Stages::pluck('stage_id')->toArray();

        for ($i = 0; $i<10; $i++){
            $newLectures = new Lectures();

            $randomSeconds = mt_rand(0, 86399);
            $randomTime = date('H:i', $randomSeconds);

            $newLectures->name = "lecture_".mt_rand(1,5000);
            $newLectures->description = Str::random(150);
            // obrazok
            $imageIndex = mt_rand(0,15);
            $newLectures->image = "speaker{$imageIndex}.webp";

            $newLectures->capacity = mt_rand(1, 100);
            $newLectures->max_capacity = mt_rand(100, 200);
            $newLectures->start = $randomTime;
            $newLectures->end = $randomTime;
            $newLectures->stage_id = $stages[array_rand($stages)];
            $newLectures->save();}
    }
}
