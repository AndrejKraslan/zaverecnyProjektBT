<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function index()
    {
        $users = Users::all();

        $usersJson = $users->map(function ($user) {
            return [
                'ID' => $user->user_id,
                'Meno' => $user->first_name,
                'Priezvisko' => $user->last_name,
                'Email' => $user->email,
                'Password' => $user->password,
                'Admin' => $user->is_admin,
                'CreatedAt' => $user->created_at,
                'UpdatedAt' => $user->updated_at
            ];
        });

        return response()->json($usersJson);
    }

    public function makeAdmin(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id'
        ]);

        $user = Users::find($validated['user_id']);
        $user->is_admin = 1;
        $user->save();

        return response()->json(['message' => 'The user has been granted admin privileges.']);
    }

    public function removeAdmin(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id'
        ]);

        $user = Users::find($validated['user_id']);
        $user->is_admin = 0;
        $user->save();

        return response()->json(['message' => 'The user\'s admin privileges have been revoked.']);
    }
}
