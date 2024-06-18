<?php

namespace App\Http\Controllers;

use App\Models\UserLecture;
use App\Models\Lectures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersHasLecturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['register']);
    }

    public function index()
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

    public function register(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'lecture_id' => 'required|exists:lectures,lecture_id',
        ]);


        $user = Auth::user();

        $requestedLecture = Lectures::find($validatedData['lecture_id']);
        // Check if the user is already registered for this lecture
        $existingRegistration = UserLecture::where('user_id', $user->user_id)
            ->where('lecture_id', $validatedData['lecture_id'])
            ->first();

        if ($existingRegistration) {
            return response()->json(['message' => 'You are already registered for this lecture'], 409);
        }
        $overlappingLecture = Lectures::whereHas('users', function ($query) use ($user) {
            $query->where('users.user_id', $user->user_id);
        })
            ->where(function ($query) use ($requestedLecture) {
                $query->where('start', '<', $requestedLecture->end)
                    ->where('end', '>', $requestedLecture->start);
            })
            ->first();

        if ($overlappingLecture) {
            return response()->json(['message' => 'You are already registered for a lecture that overlaps with the requested lecture'], 409);
        }


        $userLecture = UserLecture::create([
            'user_id' => $user->user_id,
            'lecture_id' => $validatedData['lecture_id'],
        ]);

        return response()->json(['message' => 'Successfully registered for the lecture', 'registration' => $userLecture], 201);
    }

    public function cancelRegistration(Request $request)
    {
        $validatedData = $request->validate([
            'lecture_id' => 'required|exists:lectures,lecture_id',
        ]);

        $user = Auth::user();

        $registration = UserLecture::where('user_id', $user->user_id)
            ->where('lecture_id', $validatedData['lecture_id'])
            ->first();

        if (!$registration) {
            return response()->json(['message' => 'Registration not found'], 404);
        }

        $registration->delete();

        return response()->json(['message' => 'Registration canceled successfully']);
    }
}
