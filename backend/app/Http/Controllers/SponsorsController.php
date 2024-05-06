<?php

namespace App\Http\Controllers;

use App\Models\Sponsors;
use Illuminate\Http\Request;

class SponsorsController extends Controller
{
    public function test()
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
}
