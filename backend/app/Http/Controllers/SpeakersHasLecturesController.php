<?php

namespace App\Http\Controllers;

use App\Models\SpeakerLecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpeakersHasLecturesController extends Controller
{
    public function index()
    {
        $speakersLectures = SpeakerLecture::all();

        $speakersLecturesJson = $speakersLectures->map(function ($speakerLecture) {
            return [
                'ID' => $speakerLecture->id,
                'SpeakerID' => $speakerLecture->speaker_id,
                'LectureID' => $speakerLecture->lecture_id,
                'CreatedAt' => $speakerLecture->created_at,
                'UpdatedAt' => $speakerLecture->updated_at,
            ];
        });

        return response()->json($speakersLecturesJson);
    }

    // Method to assign a speaker to a lecture
    public function assignSpeakerToLecture(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'speaker_id' => 'required|exists:speakers,speaker_id',
            'lecture_id' => 'required|exists:lectures,lecture_id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check if the association already exists
        $existingRecord = SpeakerLecture::where('speaker_id', $request->speaker_id)
            ->where('lecture_id', $request->lecture_id)
            ->first();

        if ($existingRecord) {
            return response()->json(['message' => 'This speaker is already assigned to this lecture'], 409);
        }

        // Create the new record
        $speakerLecture = SpeakerLecture::create([
            'speaker_id' => $request->speaker_id,
            'lecture_id' => $request->lecture_id,
        ]);

        return response()->json(['message' => 'Speaker assigned to lecture successfully', 'data' => $speakerLecture], 201);
    }
}
