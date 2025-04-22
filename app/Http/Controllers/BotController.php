<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BotController extends Controller
{
    public function all()
    {
        $bots= Bot::with('niche')->latest()->get();
        return response()->json($bots);
    }

    // POST /bots/create
    public function create(Request $request)
{
    // $request->validate([
    //  mage upload validation
    // ]);
    $validatedData=Validator::make($request->all(), [
        'niche_id' => 'required|exists:niches,id',
        'name' => 'required|string|max:255',
        'system_prompt' => 'required|string',
        'openai_model' => 'required|string',
        'fine_tuned_model_id' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
    ]);
    if ($validatedData->fails()) {
        return response()->json(['errors' => $validatedData->errors()], 422);
    }
    $data = $request->only([
        'niche_id',
        'name',
        'system_prompt',
        'openai_model',
        'fine_tuned_model_id',
    ]);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('bot_images', 'public');
    }

    $bot = Bot::create($data);

    return response()->json(['message' => 'Bot created', 'bot' => $bot]);
}


    // GET /bots/{id}
    public function get($id)
    {
        $bot = Bot::with('niche')->findOrFail($id);
        return response()->json($bot);
    }

    // POST /bots/update/{id}
    public function update(Request $request, $id)
    {
        $bot = Bot::findOrFail($id);

        // $request->validate();
        $validatedData=Validator::make($request->all(), [
            'niche_id' => 'required|exists:niches,id',
            'name' => 'required|string|max:255',
            'system_prompt' => 'required|string',
            'openai_model' => 'required|string',
            'fine_tuned_model_id' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
        ]);
        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }
        $data = $request->only([
            'niche_id',
            'name',
            'system_prompt',
            'openai_model',
            'fine_tuned_model_id',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('bot_images', 'public');
        }

        $bot->update($data);

        return response()->json(['message' => 'Bot updated', 'bot' => $bot]);
    }

    // DELETE /bots/delete/{id}
    public function delete($id)
    {
        $bot = Bot::findOrFail($id);
        $bot->delete();

        return response()->json(['message' => 'Bot deleted']);
    }
}
