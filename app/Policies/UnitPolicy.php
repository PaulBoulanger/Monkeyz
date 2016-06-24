<?php

namespace App\Policies;

use App\User;
use App\Unit;

class UnitPolicy
{

    public function recruit(User $user, Unit $unit)
    {
        if ($unit->type === 'scout') {
            foreach ($user->buildings as $building) {
                if ($building->id === 1)
                    return true;
            }
            return false;
        }

        if ($unit->type === 'speed') {
            foreach ($user->buildings as $building) {
                if ($building->id === 2)
                    return true;
            }
            return false;
        }

        if ($unit->type === 'warrior') {
            foreach ($user->buildings as $building) {
                if ($building->id === 3)
                    return true;
            }
            return false;
        }

        if ($unit->type === 'master') {
            foreach ($user->buildings as $building) {
                if ($building->id === 5)
                    return true;
            }
            return false;
        }

        return true;
    }
}
