<?php

namespace App\Http\Controllers;

use App\Models\SpeakerLecture;
use App\Models\Lectures;
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

// pridelit speakera k prednaske

    public function register(Request $request)
    {
        // kontrola ci existuju
        $validator = Validator::make($request->all(), [
            'speaker_id' => 'required|exists:speakers,speaker_id',
            'lecture_id' => 'required|exists:lectures,lecture_id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // vybrana prednaska
        $requestedLecture = Lectures::find($request->lecture_id);

        // kontrola duplicity
        $existingRecord = SpeakerLecture::where('speaker_id', $request->speaker_id)
            ->where('lecture_id', $request->lecture_id)
            ->first();

        if ($existingRecord) {
            return response()->json(['message' => 'This speaker is already assigned to this lecture'], 409);
        }

        // kontrola ci je speaker dostupny
        $overlappingLectureWithSpeaker = SpeakerLecture::where('speaker_id', $request->speaker_id)
            ->get()
            ->pluck('lecture_id')
            ->map(function ($lectureId) {
                return Lectures::find($lectureId);
            })
            ->filter(function ($lecture) use ($requestedLecture) {
                return $lecture->start < $requestedLecture->end && $lecture->end > $requestedLecture->start;
            })
            ->first();

        if ($overlappingLectureWithSpeaker) {
            return response()->json(['message' => 'This speaker is already assigned to another lecture at the specified time.'], 409);
        }

        // zapis

        $speakerLecture = SpeakerLecture::create([
            'speaker_id' => $request->speaker_id,
            'lecture_id' => $request->lecture_id,
        ]);

        return response()->json(['message' => 'Speaker assigned to lecture successfully', 'data' => $speakerLecture], 201);
    }

    public function cancelRegistration(Request $request)
    {
        // kontorla existencie
        $validatedData = $request->validate([
            'lecture_id' => 'required|exists:lectures,lecture_id',
            'speaker_id' => 'required|exists:speakers,speaker_id',
        ]);

        // najst zaznam v medzitabulke
        $registration = SpeakerLecture::where('speaker_id', $validatedData['speaker_id'])
            ->where('lecture_id', $validatedData['lecture_id'])
            ->first();

        if (!$registration) {
            return response()->json(['message' => 'Speaker registration not found'], 404);
        }

        // dlete
        $registration->delete();

        return response()->json(['message' => 'Speaker registration canceled successfully']);
    }
}
