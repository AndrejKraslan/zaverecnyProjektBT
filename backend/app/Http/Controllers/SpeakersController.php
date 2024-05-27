<?php

namespace App\Http\Controllers;

use App\Models\Speakers;
use Illuminate\Http\Request;

class SpeakersController extends Controller
{
    public function index()
    {
        $speakers = Speakers::all();

        $speakersJson = $speakers->map(function ($speaker) {
            return [
                'ID' => $speaker->speaker_id,
                'Name' => $speaker->name,
                'Description_Short' => $speaker->description_short,
                'Description_Long' => $speaker->description_long,
                'Image' => $speaker->image,
                'Facebook' => $speaker->facebook_url,
                'Instagram' => $speaker->instagram_url,
                'Twitter' => $speaker->twitter_url,
                'Web' => $speaker->web_url,
            ];
        });

        return response()->json($speakersJson);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'description_short' => 'required|string|max:150',
            'description_long' => 'required|string',
            'image' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|string|max:500',
            'instagram_url' => 'nullable|string|max:500',
            'twitter_url' => 'nullable|string|max:500',
            'web_url' => 'nullable|string|max:500',
        ]);

        $speaker = Speakers::create($validatedData);

        return response()->json($speaker, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'description_short' => 'required|string|max:150',
            'description_long' => 'required|string',
            'image' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|string|max:500',
            'instagram_url' => 'nullable|string|max:500',
            'twitter_url' => 'nullable|string|max:500',
            'web_url' => 'nullable|string|max:500',
        ]);

        $speaker = Speakers::find($id);

        if (!$speaker) {
            return response()->json(['message' => 'Speaker not found'], 404);
        }

        $speaker->update($validatedData);

        return response()->json($speaker);
    }

    public function delete($id)
    {
        $speaker = Speakers::find($id);

        if (!$speaker) {
            return response()->json(['message' => 'Speaker not found'], 404);
        }

        $speaker->delete();

        return response()->json(['message' => 'Speaker deleted successfully']);
    }

    public function show($id)
    {
        $speaker = Speakers::find($id);

        if (!$speaker) {
            return response()->json(['message' => 'Speaker not found'], 404);
        }

        return response()->json($speaker);
    }
}
