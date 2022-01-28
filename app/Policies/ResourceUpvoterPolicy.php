<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ResourceUpvoter;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourceUpvoterPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, ResourceUpvoter $upvote)
    {
        return $upvote->upvoter()->is($user);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, ResourceUpvoter $upvote)
    {
        return $upvote->upvoter()->is($user);
    }

    public function delete(User $user, ResourceUpvoter $upvote)
    {
        return $upvote->upvoter()->is($user);
    }

    public function restore(User $user, ResourceUpvoter $upvote)
    {
        return $upvote->upvoter()->is($user);
    }

    public function forceDelete(User $user, ResourceUpvoter $upvote)
    {
        return $upvote->upvoter()->is($user);
    }
}
