<?php

namespace Database\Seeders;

use App\Models\Lectures;
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
        for ($i = 0; $i<10; $i++){
            $newLectures = new Lectures();

            $randomSeconds = mt_rand(0, 86399);
            $randomTime = date('H:i:s', $randomSeconds);

            $newLectures->name = "lecture_".mt_rand(1,5000);
            $newLectures->description = Str::random(150);
            $newLectures->image = Str::random(100);
            $newLectures->capacity = mt_rand(1, 100);
            $newLectures->max_capacity = mt_rand(100, 200);
            $newLectures->start = $randomTime;
            $newLectures->end = $randomTime;
            //$newLectures->speaker_id = Str::random(100); // doplnit id z speakerov a stage ked budu
            //$newLectures->stage_id = Str::random(100);
            $newLectures->save();}
    }
}
