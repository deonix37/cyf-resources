<?php

namespace App\Models;

use App\Models\EngineRelease;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Resource extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function resourceType()
    {
        return $this->belongsTo(ResourceType::class);
    }

    public function engineRelease()
    {
        return $this->belongsTo(EngineRelease::class);
    }

    public function resourceLinks()
    {
        return $this->hasMany(ResourceLink::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function upvoters()
    {
        return $this->belongsToMany(
            User::class, 'resource_upvoter', 'resource_id', 'upvoter_id',
        )->withTimestamps();
    }

    public function currentUserUpvote()
    {
        return $this->hasOne(ResourceUpvoter::class)->where('upvoter_id', Auth::id());
    }
}
