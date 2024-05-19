<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        if(!auth()->attempt(['email'=>$request->email, 'password'=>$request->password]))
        {
            return response()->json(['error'=>'try again'],401);
        }

        $token = auth()->user()->createToken('personal-token',expiresAt:now()->addDay(),abilities:['show:user'])->plainTextToken;

        return response()->json(['token'=>$token]);
    }
}
