<?php

namespace App\Http\Controllers;

use App\Models\Speakers;
use Illuminate\Http\Request;

class SpeakersController extends Controller
{
    public function test()
    {
        $speakers = Speakers::all();

        $speakersJson = $speakers->map(function ($speaker) {
            return [
                'ID' => $speaker->speaker_id,
                'Name' => $speaker->name,
                'Description_Short' => $speaker->description_short,
                'Description_Long' => $speaker->description_long,
                'Facebook' => $speaker->facebook_url,
                'Instagram' => $speaker->instagram_url,
                'Twitter' => $speaker->twitter_url,
                'Web' => $speaker->web_url,
                'CreatedAt' => $speaker->created_at,
                'UpdatedAt' => $speaker->updated_at
            ];
        });

        return response()->json($speakersJson);
    }
}
