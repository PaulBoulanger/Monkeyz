<?php

namespace App\Policies;

use App\User;
use App\Unit;

class UnitPolicy
{

    public function recruit(User $user, Unit $unit)
    {
        if ($unit->type === 'scout')
            return $unit->required();


        if ($unit->type === 'speed')
            return $unit->required();


        if ($unit->type === 'warrior')
            return $unit->required();


        if ($unit->type === 'master')
            return $unit->required();


        return true;
    }
}
