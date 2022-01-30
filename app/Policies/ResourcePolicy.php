<?php

namespace App\Policies;

use App\Models\Resource;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Resource $resource)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Resource $resource)
    {
        return $resource->uploader()->is($user) || $user->is_staff;
    }

    public function updateStatus(User $user, Resource $resource)
    {
        return $user->is_staff;
    }

    public function delete(User $user, Resource $resource)
    {
        return $resource->uploader()->is($user);
    }

    public function restore(User $user, Resource $resource)
    {
        return $resource->uploader()->is($user);
    }

    public function forceDelete(User $user, Resource $resource)
    {
        return $resource->uploader()->is($user);
    }
}
