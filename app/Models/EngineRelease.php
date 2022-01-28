<?php

namespace App\Models;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngineRelease extends Model
{
    use HasFactory;

    public function engine()
    {
        return $this->belongsTo(Engine::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}
