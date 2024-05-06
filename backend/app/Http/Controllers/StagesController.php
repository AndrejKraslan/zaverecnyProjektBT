<?php

namespace App\Http\Controllers;

use App\Models\Stages;
use Illuminate\Http\Request;

class StagesController extends Controller
{
    public function test()
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
}
