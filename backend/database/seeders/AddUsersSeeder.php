<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i<10; $i++){
            $newUser = new Users();
            $newUser->first_name = "user_name".mt_rand(1,5000);
            $newUser->last_name = "user_surname".mt_rand(1,5000);
            $newUser->email = "user_".mt_rand(1,5000) . "@gmail.com";
            $newUser->password = Str::random(10);
            $newUser->is_admin = 0;
            $newUser->save();}
    }
}
