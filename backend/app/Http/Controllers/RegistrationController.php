<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Users::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin ?? false, // defoult false pri registracii
        ]);

        // Odoslanie potvrdenia emailu po úspešnej registrácii používateľovi
        $userMessage = "Thank you for registering, {$user->first_name} {$user->last_name}! Your registration is now complete.";
        Mail::raw($userMessage, function ($mail) use ($user) {
            $mail->to($user->email) // email, ktorý zadal používateľ
            ->subject('Registration Confirmation')
                ->from('test@jakubkrakovik.online');
        });

        // Odoslanie emailu o novej registrácii na predvolenú emailovú adresu
        $adminMessage = "New user registered: {$user->first_name} {$user->last_name}, Email: {$user->email}";
        Mail::raw($adminMessage, function ($mail) {
            $mail->to('andrejkraslan8@gmail.com') // predvolený email
            ->subject('New User Registration')
                ->from('test@jakubkrakovik.online');
        });

        return response()->json(['message' => 'User registered successfully!'], 201);
    }
}
