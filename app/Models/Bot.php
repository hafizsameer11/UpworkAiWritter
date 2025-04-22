<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;
    protected $fillable = ['niche_id', 'name', 'system_prompt', 'openai_model', 'fine_tuned_model_id','image' ];

    public function niche()
    {
        return $this->belongsTo(Niche::class);
    }
}
