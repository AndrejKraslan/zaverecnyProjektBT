<?php

namespace Database\Seeders;

use App\Models\Stages;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AddStagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        for ($i = 0; $i<10; $i++){
            $newStages = new Stages();
            $newStages->name = "room_".mt_rand(1,5000);
            $newStages->date = mt_rand(2000,2100).'-'.mt_rand(1,12).'-'.mt_rand(1,30);
            $newStages->room = "room_".mt_rand(1,5000);
            $newStages->save();}
    }
}
