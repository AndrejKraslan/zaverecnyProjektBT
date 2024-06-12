<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $newUsers = new Users();
            $newUsers->first_name = "admin";
            $newUsers->last_name = "admin";
            $newUsers->email = "admin" . "@gmail.com";
            $newUsers->password = 'root';
            $newUsers->is_admin = 1;
            $newUsers->save();
    }
}
