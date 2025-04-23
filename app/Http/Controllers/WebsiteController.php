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
}
