<?php

namespace App\Http\Controllers;

use App\Models\Sponsors;
use Illuminate\Http\Request;

class SponsorsController extends Controller
{
    public function index()
    {
        $sponsors = Sponsors::all();

        $sponsorsJson = $sponsors->map(function ($sponsor) {
            return [
                'ID' => $sponsor->sponsor_id,
                'Name' => $sponsor->name,
                'URL' => $sponsor->url,
                'Description' => $sponsor->description,
                'Image' => $sponsor->image,
                'CreatedAt' => $sponsor->created_at,
                'UpdatedAt' => $sponsor->updated_at
            ];
        });

        return response()->json($sponsorsJson);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'description' => 'required|string',
            'image' => 'nullable|string',
        ]);

        $sponsor = Sponsors::create($validatedData);

        return response()->json($sponsor, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'url' => 'required|url|max:500',
            'description' => 'required|string',
            'image' => 'nullable|string|max:500',
        ]);

        $sponsor = Sponsors::find($id);

        if (!$sponsor) {
            return response()->json(['message' => 'Sponsor not found'], 404);
        }

        $sponsor->update($validatedData);

        return response()->json($sponsor);
    }

    public function delete($id)
    {
        $sponsor = Sponsors::find($id);

        if (!$sponsor) {
            return response()->json(['message' => 'Sponsor not found'], 404);
        }

        $sponsor->delete();

        return response()->json(['message' => 'Sponsor deleted successfully']);
    }

    public function show($id)
    {
        $sponsor = Sponsors::find($id);

        if (!$sponsor) {
            return response()->json(['message' => 'Sponsor not found'], 404);
        }

        return response()->json($sponsor);
    }
}

