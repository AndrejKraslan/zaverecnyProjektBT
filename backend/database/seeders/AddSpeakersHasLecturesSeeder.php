<?php

namespace Database\Seeders;

use App\Models\Lectures;
use App\Models\SpeakerLecture;
use App\Models\Speakers;
use App\Models\UserLecture;
use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddSpeakersHasLecturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $speakers = Speakers::pluck('speaker_id')->toArray();
        $lectures = Lectures::pluck('lecture_id')->toArray();

        for ($i = 0; $i<10; $i++){
            $newSpeakerLecture = new SpeakerLecture();

            $newSpeakerLecture->speaker_id = $speakers[array_rand($speakers)];
            $newSpeakerLecture->lecture_id = $lectures[array_rand($lectures)];

            $newSpeakerLecture->save();

        }
        //
    }
}
