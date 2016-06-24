<?php

namespace App\Policies;

use App\Base;
use App\User;

class BasePolicy
{

    public function loot(User $user, Base $base)
    {
        if ($base->user_id === $user->id)
            return false;

        return true;
    }
}
