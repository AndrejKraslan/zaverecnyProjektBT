<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function index($id)
    {
        $images = Images::where('year_id', $id)->get();

        return response()->json($images);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|string|max:500',
            'year_id' => 'required|exists:years,year_id',
        ]);

        $image = Images::create($validatedData);

        return response()->json($image, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'image' => 'required|string|max:500',
            'year_id' => 'required|exists:years,year_id',
        ]);

        $image = Images::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $image->update($validatedData);

        return response()->json($image);
    }

    public function delete($id)
    {
        $image = Images::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }

}
