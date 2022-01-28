<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ResourceUpvoter extends Pivot
{
    public $incrementing = true;

    public function resource() {
        return $this->belongsTo(Resource::class);
    }

    public function upvoter() {
        return $this->belongsTo(User::class, 'upvoter_id');
    }
}
