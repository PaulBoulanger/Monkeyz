<?php

namespace App\Policies;

use App\User;
use App\Building;

class BuildingPolicy
{

    public function can(User $user, Building $building)
    {

        foreach ($user->buildings as $userBuilding) {
            if ($userBuilding->id === $building->id)
                return false;
        }

        switch ($building->level) {
            case 0 :
                return true;
                break;
            case 1 :
                if ($user->buildings()->where(['level' => 0, 'type' => $building->type])->first())
                    return true;
                else
                    return false;
                break;
            case 2 :
                if ($user->buildings()->where(['level' => 1, 'type' => $building->type])->first())
                    return true;
                else
                    return false;
                break;
        }

        return true;
    }
}
