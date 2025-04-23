<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthViewController extends Controller
{
    public function showSignup()
    {
        return view('app.auth.signup');
    }

    public function showLogin()
    {
        return view('app.auth.login');
    }

    public function showForgot()
    {
        return view('app.auth.forgot');
    }

    public function showVerifyCode(Request $request)
    {
        return view('app.auth.verify_code')->with('email', $request->query('email'));
    }

    public function showNewPassword(Request $request)
    {
        return view('app.auth.set_new_password')->with([
            'email' => $request->query('email'),
            'code' => $request->query('code'),
        ]);
    }
}
