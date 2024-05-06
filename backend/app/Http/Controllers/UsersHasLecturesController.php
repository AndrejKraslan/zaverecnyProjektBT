<?php

namespace App\Http\Controllers;

use App\Models\UserLecture;
use Illuminate\Http\Request;

class UsersHasLecturesController extends Controller
{
    public function test()
    {
        $usersLectures = UserLecture::all();

        $usersLectureJson = $usersLectures->map(function ($userLecture) {
            return [
                'ID' => $userLecture->id,
                'user' => $userLecture->user_id,
                'lecture' => $userLecture->lecture_id,
                'CreatedAt' => $userLecture->created_at,
                'UpdatedAt' => $userLecture->updated_at


            ];
        });

        return response()->json($usersLectureJson);
    }
}
