<?php

namespace App\Observers\User;

use App\Models\Auth\User;

/**
 * Class UserObserver.
 */
class UserObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\Models\Auth\User  $user
     */
    public function created(User $user): void
    {
   
    }

    /**
     * Listen to the User updated event.
     *
     * @param  \App\Models\Auth\User  $user
     */
    public function updated(User $user): void
    {
       
    }

}
