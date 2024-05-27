<?php

namespace App\Http\Controllers;

use App\Models\Lectures;
use Illuminate\Http\Request;

class LecturesController extends Controller
{
    public function index()
    {
        $lectures = Lectures::with('speakers')->get();

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
                'UpdatedAt' => $lecture->updated_at,
                'Speakers' => $lecture->speakers->map(function ($speaker) {
                    return [
                        'ID' => $speaker->speaker_id,
                        'Name' => $speaker->name,
                        'DescriptionShort' => $speaker->description_short,
                        'DescriptionLong' => $speaker->description_long,
                        'Image' => $speaker->image,
                        'FacebookURL' => $speaker->facebook_url,
                        'InstagramURL' => $speaker->instagram_url,
                        'TwitterURL' => $speaker->twitter_url,
                        'WebURL' => $speaker->web_url,
                    ];
                }),
            ];
        });

        return response()->json($lecturesJson);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:500',
            'capacity' => 'required|integer',
            'max_capacity' => 'required|integer',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'required|date_format:Y-m-d H:i:s',
            'speaker_id' => 'required|integer|exists:speakers,speaker_id',
            'stage_id' => 'required|integer|exists:stages,stage_id',
        ]);

        // Check for overlapping lectures on the same stage
        $overlappingLecture = Lectures::where('stage_id', $validatedData['stage_id'])
            ->where(function ($query) use ($validatedData) {
                $query->where('start', '<', $validatedData['end'])
                    ->where('end', '>', $validatedData['start']);
            })
            ->first();

        if ($overlappingLecture) {
            return response()->json(['message' => 'A lecture already exists on this stage at the specified time.'], 409);
        }

        $lecture = Lectures::create($validatedData);

        return response()->json($lecture, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:500',
            'capacity' => 'required|integer',
            'max_capacity' => 'required|integer',
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'required|date_format:Y-m-d H:i:s',
            'speaker_id' => 'required|integer|exists:speakers,speaker_id',
            'stage_id' => 'required|integer|exists:stages,stage_id',
        ]);

        $lecture = Lectures::find($id);

        if (!$lecture) {
            return response()->json(['message' => 'Lecture not found'], 404);
        }

        // Check for overlapping lectures on the same stage, excluding the current lecture
        $overlappingLecture = Lectures::where('stage_id', $validatedData['stage_id'])
            ->where('lecture_id', '!=', $id)
            ->where(function ($query) use ($validatedData) {
                $query->where('start', '<', $validatedData['end'])
                    ->where('end', '>', $validatedData['start']);
            })
            ->first();

        if ($overlappingLecture) {
            return response()->json(['message' => 'A lecture already exists on this stage at the specified time.'], 409);
        }

        $lecture->update($validatedData);

        return response()->json($lecture);
    }

    public function delete($id)
    {
        $lecture = Lectures::find($id);

        if (!$lecture) {
            return response()->json(['message' => 'Lecture not found'], 404);
        }

        $lecture->delete();

        return response()->json(['message' => 'Lecture deleted successfully']);
    }

    public function show($id)
    {
        $lecture = Lectures::find($id);

        if (!$lecture) {
            return response()->json(['message' => 'Lecture not found'], 404);
        }

        return response()->json($lecture);
    }
}
