<?php

namespace App\Policies;

use App\Base;
use App\User;
use App\Unit_user;

class BasePolicy
{

    public function loot(User $user, Base $base)
    {

        $myArmy = Unit_user::where('user_id', $user->id)->where('unit_id', '!=', 1)->get();
        $ennemyArmy = Unit_user::where('user_id', $base->user->id)->where('unit_id', '!=', 1)->get();

        if (count($myArmy) <= 0)
            return false;

        if (count($ennemyArmy) <= 0)
            return false;

        return true;
    }
}
