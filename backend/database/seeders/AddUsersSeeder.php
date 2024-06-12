<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i<10; $i++){
            $newUsers = new Users();
            $newUsers->first_name = "user_name".mt_rand(1,5000);
            $newUsers->last_name = "user_surname".mt_rand(1,5000);
            $newUsers->email = "user_".mt_rand(1,5000) . "@gmail.com";
            $newUsers->password = 'password';
            $newUsers->is_admin = 0;
            $newUsers->save();}
    }
}
