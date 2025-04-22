<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use App\Models\Project;
use App\Models\Proposal;
use App\Services\OpenAIService;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'bot_id' => 'required|exists:bots,id',
            'job_post' => 'required|string',
            'custom_prompt' => 'nullable|string',
        ]);

        $bot = Bot::with('niche')->findOrFail($validated['bot_id']);
        $niche = $bot->niche;
        $projects = Project::where('niche_id', $niche->id)->get();

        $openai = new OpenAIService();
        $aiResponse = $openai->generateProposal(
            $bot,
            $validated['job_post'],
            $validated['custom_prompt'] ?? null,
            $projects
        );

        // Save proposal
        $proposal = Proposal::create([
            'user_id' => $validated['user_id'],
            'niche_id' => $niche->id,
            'bot_id' => $bot->id,
            'job_post' => $validated['job_post'],
            'user_prompt' => $validated['custom_prompt'] ?? null,
            'ai_response' => $aiResponse,
            'used_projects' => $projects->map(fn ($p) => [
                'title' => $p->title,
                'url' => $p->project_url,
            ])->values()->toArray(),
        ]);

        return response()->json([
            'message' => 'Proposal generated successfully.',
            'proposal' => $proposal,
        ]);
    }

    public function all()
    {
        return Proposal::with('bot', 'niche')->latest()->get();
    }

    public function get($id)
    {
        return Proposal::with('bot', 'niche', 'user')->findOrFail($id);
    }
    //
}
