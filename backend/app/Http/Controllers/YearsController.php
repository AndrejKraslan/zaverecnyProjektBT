<?php

namespace App\Http\Controllers;

use App\Models\Years;
use Illuminate\Http\Request;

class YearsController extends Controller
{
    public function index()
    {
        $years = Years::all();

        return response()->json($years);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'year' => 'required|integer|unique:years,year',
        ]);

        $year = Years::create($validatedData);

        return response()->json($year, 201);
    }

    public function delete($id)
    {
        $year = Years::find($id);

        if (!$year) {
            return response()->json(['message' => 'Year not found'], 404);
        }

        $year->delete();

        return response()->json(['message' => 'Year deleted successfully']);
    }

}
