<?php

namespace Database\Seeders;

use App\Models\Speakers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddSpeakersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $newSpeaker = new Speakers();
            $newSpeaker->name = "speaker_" . mt_rand(1, 5000);
            $newSpeaker->description_short = Str::random(50);
            $newSpeaker->description_long = Str::random(250);

            // obrazky
            $imageIndex = mt_rand(0, 15);
            $newSpeaker->image = "speaker{$imageIndex}.webp";

            $newSpeaker->facebook_url = Str::random(100);
            $newSpeaker->instagram_url = Str::random(100);
            $newSpeaker->twitter_url = Str::random(100);
            $newSpeaker->web_url = Str::random(100);
            $newSpeaker->save();
        }
    }
}
