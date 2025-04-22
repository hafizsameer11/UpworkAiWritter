<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['niche_id', 'title', 'description', 'project_url'];

    public function niche()
    {
        return $this->belongsTo(Niche::class);
    }
}
