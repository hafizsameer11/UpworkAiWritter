<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function bots() {
        $bots = Bot::with('niche')->get();
        return view('app.UserBots',compact("bots"));
    }

    public function chatCan(string $id) {
        $bot = Bot::with('niche')->findOrFail($id);
        return view('app.chat',compact('bot'));
    }
    public function logout(){
        auth()->logout();
        return redirect()->route('auth.login');
    }
}
