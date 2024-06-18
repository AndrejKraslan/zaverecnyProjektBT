<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sponsors;
use Illuminate\Support\Str;

class AddSponsorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i<10; $i++){
            $newSponsors = new Sponsors();
            $newSponsors->name = "sponsor_".mt_rand(1,5000);
            $newSponsors->url = "www.sponsor_".mt_rand(1,5000)."com";
            $newSponsors->description = Str::random(250);
            $imageIndex = mt_rand(0, 15);
            $newSponsors->image = "speaker{$imageIndex}.webp";
            $newSponsors->save();}
    }
}
