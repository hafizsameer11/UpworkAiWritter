<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'niche_id', 'bot_id', 'job_post', 'user_prompt', 'ai_response', 'used_projects'];

    protected $casts = [
        'used_projects' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    public function niche()
    {
        return $this->belongsTo(Niche::class);
    }
}
