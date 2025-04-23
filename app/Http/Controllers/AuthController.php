<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\SendCode;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Account created successfully.']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        Auth::login($user);
        return response()->json(['message' => 'Login successful','user'=>$user]);
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();
        $user->remember_token = rand(100000, 999999);
        $user->save();

        Mail::to($user->email)->send(new SendCode($user->remember_token));

        return response()->json(['message' => 'Reset code sent to your email.']);
    }

    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6'
        ]);

        $user = User::where('email', $request->email)->where('remember_token', $request->code)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification code'], 422);
        }

        return response()->json(['message' => 'Code verified']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('email', $request->email)->where('remember_token', $request->code)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid reset attempt'], 422);
        }

        $user->password = Hash::make($request->password);
        $user->remember_token = null;
        $user->save();

        return response()->json(['message' => 'Password reset successful']);
    }
}
