<?php

namespace App\Policies;

use App\User;
use App\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function before($user)
    {
        if($user->name =='medha rani'){
            return true;
        }
    }

    public function update(User $user, Thread $thread)
    {
        return $thread->user_id == $user->id;
    }
}
