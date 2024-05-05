<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AddUsersSeeder::class);
        $this->call(AddStagesSeeder::class);
        $this->call(AddSponsorsSeeder::class);
        $this->call(AddSpeakersSeeder::class);
        $this->call(AddLecturesSeeder::class);
        $this->call(AddCommentsSeeder::class);
        $this->call(AddUsersHasLectures::class);


    }
}
