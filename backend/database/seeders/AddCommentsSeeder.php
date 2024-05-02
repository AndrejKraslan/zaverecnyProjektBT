<?php

namespace Database\Seeders;

use App\Models\Comments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i<10; $i++){
            $newComments = new Comments();
            $newComments->name = "comment_".mt_rand(1,5000);
            $newComments->description = Str::random(200);
            $newComments->image = Str::random(100);

            $newComments->save();}
    }
}
