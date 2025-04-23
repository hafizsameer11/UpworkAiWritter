<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function all()
    {
        return Project::with('niche')->latest()->get();
    }

    // GET /projects/{id}
    public function get($id)
    {
        return Project::with('niche')->findOrFail($id);
    }

    // POST /projects/create
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'niche_id' => 'required|exists:niches,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_url' => 'required|string',
        ]);

        if (!$validatedData) {
            return response()->json(['message' => 'Validation failed', 'errors' => $request->errors()], 422);
        }

        $project = Project::create($request->only([
            'niche_id',
            'title',
            'description',
            'project_url',
        ]));

        return response()->json(['message' => 'Project created', 'project' => $project]);
    }

    // POST /projects/update/{id}
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'niche_id' => 'required|exists:niches,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_url' => 'required|url',
        ]);

        $project->update($request->only([
            'niche_id',
            'title',
            'description',
            'project_url',
        ]));

        return response()->json(['message' => 'Project updated', 'project' => $project]);
    }

    // DELETE /projects/delete/{id}
    public function delete($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted']);
    }
}
