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
            //'capacity' => 'required|integer',
            'max_capacity' => 'required|integer',
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'stage_id' => 'required|integer|exists:stages,stage_id',
        ]);

        // kontrola prekryvania prednasok
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
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'stage_id' => 'required|integer|exists:stages,stage_id',
        ]);

        $lecture = Lectures::find($id);

        if (!$lecture) {
            return response()->json(['message' => 'Lecture not found'], 404);
        }

        // konrola prekryvania, mimo editovanej
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

}
