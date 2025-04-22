<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Bot;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    public function generateProposal(Bot $bot, string $jobPost, ?string $customPrompt = null, $projects = [])
    {
        // Build project references
        $projectContext = "";
        foreach ($projects as $project) {
            $projectContext .= "- {$project->title}: {$project->project_url}\n{$project->description}\n\n";
        }

        // Build system prompt
        $systemMessage = $bot->system_prompt . "\n\nHere are some of our relevant projects:\n" . $projectContext;

        // Build user prompt (final input to AI)
        $userMessage = "Here is the job post:\n\n" . $jobPost;

        if ($customPrompt) {
            $userMessage .= "\n\nAdditional Instructions:\n" . $customPrompt;
        }

        // Call OpenAI API
        $response = Http::withToken(env('OPENAI_API_KEY','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'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => $bot->fine_tuned_model_id ?? $bot->openai_model,
            'messages' => [
                ['role' => 'system', 'content' => $systemMessage],
                ['role' => 'user', 'content' => $userMessage],
            ],
            'temperature' => 0.8,
            'max_tokens' => 800,
        ]);
        Log::info('OpenAI API Response:', ['response' => $response->json()]);
        return $response->json()['choices'][0]['message']['content'] ?? 'No AI response.';
    }
}
