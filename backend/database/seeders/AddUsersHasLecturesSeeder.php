<?php

namespace Database\Seeders;

use App\Models\Lectures;
use App\Models\UserLecture;
use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddUsersHasLecturesSeeder extends Seeder
{
    public function run(): void
    {
        $users = Users::pluck('user_id')->toArray();
        $lectures = Lectures::pluck('lecture_id')->toArray();

        for ($i = 0; $i<10; $i++){
            $newUserLecture = new UserLecture();

            $newUserLecture->user_id = $users[array_rand($users)];
            $newUserLecture->lecture_id = $lectures[array_rand($lectures)];

            $newUserLecture->save();

    }
}
}
