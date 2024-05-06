<?php

namespace App\Http\Controllers;

use App\Models\Lectures;
use Illuminate\Http\Request;

class LecturesController extends Controller
{
    public function test()
    {
        $lectures = Lectures::all();

        $lecturesJson = $lectures->map(function ($lecture) {
            return [
                'ID' => $lecture->lecture_id,
                'Name' => $lecture->name,
                'Description' => $lecture->description,
                'Image' => $lecture->image,
                'Capacity' => $lecture->capacity,
                'MaxCapacity' => $lecture->max_capacity,
                'Start' => $lecture->start,
                'End' => $lecture->end,
                'SpeakerID' => $lecture->speaker_id,
                'StageID' => $lecture->stage_id,
                'CreatedAt' => $lecture->created_at,
                'UpdatedAt' => $lecture->updated_at


            ];
        });

        return response()->json($lecturesJson);
    }
}
