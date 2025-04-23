<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Niche;
use Illuminate\Http\Request;

class NichesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $niches = Niche::latest()->get();
        return view('admin.niches.list',compact('niches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.niches.create');
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
        $niche = Niche::findOrFail($id);
        return view('admin.niches.view', compact('niche'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $niche = Niche::findOrFail($id);
        return view('admin.niches.update',compact('niche'));
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
