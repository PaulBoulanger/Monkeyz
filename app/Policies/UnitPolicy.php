<?php

namespace App\Policies;

use App\User;
use App\Unit;

class UnitPolicy
{

    public function recruit(User $user, Unit $unit)
    {
        if ($unit->name === 'Singe éclaireurs') {
            foreach ($user->buildings as $building) {
                if ($building->id === 1)
                    return true;
            }
            return false;
        }
        return true;
    }
}
