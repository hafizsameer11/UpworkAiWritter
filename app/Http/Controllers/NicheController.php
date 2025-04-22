<?php

namespace App\Http\Controllers;

use App\Models\Niche;
use Illuminate\Http\Request;

class NicheController extends Controller
{
    //
    public function all()
    {
        return Niche::latest()->get();
    }

    // POST /niches/create
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:niches,name',
            'slug' => 'required|string|max:255|unique:niches,slug',
            'description' => 'nullable|string',
        ]);

        $niche = Niche::create($request->only([
            'name',
            'slug',
            'description',
        ]));

        return response()->json(['message' => 'Niche created', 'niche' => $niche]);
    }

    // GET /niches/{id}
    public function get($id)
    {
        $niche = Niche::findOrFail($id);
        return response()->json($niche);
    }

    // POST /niches/update/{id}
    public function update(Request $request, $id)
    {
        $niche = Niche::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:niches,name,' . $niche->id,
            'slug' => 'required|string|max:255|unique:niches,slug,' . $niche->id,
            'description' => 'nullable|string',
        ]);

        $niche->update($request->only([
            'name',
            'slug',
            'description',
        ]));

        return response()->json(['message' => 'Niche updated', 'niche' => $niche]);
    }

    // DELETE /niches/delete/{id}
    public function delete($id)
    {
        $niche = Niche::findOrFail($id);
        $niche->delete();

        return response()->json(['message' => 'Niche deleted']);
    }
}
