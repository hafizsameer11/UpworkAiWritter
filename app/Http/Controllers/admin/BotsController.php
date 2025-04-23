<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bot;
use App\Models\Niche;
use Illuminate\Http\Request;

class BotsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bots = Bot::with('niche')->get();
        // return $bots;
        return view('admin.bots.list',compact('bots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $niches = Niche::all();
        return view('admin.bots.create', compact('niches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bot = Bot::with('niche')->findOrFail($id);
        // return $bots;
        return view('admin.bots.view',compact('bot'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $niches = Niche::all();
        $bot = Bot::findOrFail($id);
        return view('admin.bots.update', compact('bot', 'niches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
