<?php

namespace App\Http\Controllers;

use App\Models\Stages;
use Illuminate\Http\Request;

class StagesController extends Controller
{
    public function index()
    {
        $stages = Stages::all();

        $stagesJson = $stages->map(function ($stage) {
            return [
                'ID' => $stage->stage_id,
                'Name' => $stage->name,
                'Date' => $stage->date,
                'Room' => $stage->room,
                'CreatedAt' => $stage->created_at,
                'UpdatedAt' => $stage->updated_at
            ];
        });

        return response()->json($stagesJson);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d H:i:s',
            'room' => 'required|string|max:255',
        ]);

        $stage = Stages::create($validatedData);

        return response()->json($stage, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d H:i:s',
            'room' => 'required|string|max:255',
        ]);

        $stage = Stages::find($id);

        if (!$stage) {
            return response()->json(['message' => 'Stage not found'], 404);
        }

        $stage->update($validatedData);

        return response()->json($stage);
    }

    public function delete($id)
    {
        $stage = Stages::find($id);

        if (!$stage) {
            return response()->json(['message' => 'Stage not found'], 404);
        }

        $stage->delete();

        return response()->json(['message' => 'Stage deleted successfully']);
    }

    public function show($id)
    {
        $stage = Stages::find($id);

        if (!$stage) {
            return response()->json(['message' => 'Stage not found'], 404);
        }

        return response()->json($stage);
    }
}
