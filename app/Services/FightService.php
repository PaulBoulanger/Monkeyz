<?php

namespace App\Services;

use App\Unit;
use App\Unit_user;
use Illuminate\Support\Facades\Auth;

class FightService
{

    public static function fight($user, $enemy)
    {
        $myArmy = Unit_user::where('user_id', $user->id)->get();
        $enemyArmy = Unit_user::where('user_id', $enemy->id)->get();

        $bananas = $enemy->bananas / 2;
        $field = $enemy->field->fields / 2;

        $myEndurance = 0;
        $myStrength = 0;
        $myAgility = 0;

        $ennemyEndurance = 0;
        $ennemyStrength = 0;
        $ennemyAgility = 0;

        foreach ($myArmy as $unit) {
            $myEndurance += $unit->unit->endurance * $unit->units;
            $myStrength += $unit->unit->strength * $unit->units;
            $myAgility += $unit->unit->agility * $unit->units;
        }

        foreach ($enemyArmy as $unit) {
            $ennemyEndurance += $unit->unit->endurance * $unit->units;
            $ennemyStrength += $unit->unit->strength * $unit->units;
            $ennemyAgility += $unit->unit->agility * $unit->units;
        }

        $myHP = $myEndurance * 10;
        $ennemyHP = $ennemyEndurance * 10;
        $fight = true;

        if ($myAgility > $ennemyAgility) {

            while ($fight) {
                $ennemyHP = $ennemyHP - $myStrength;
                if ($ennemyHP > 0)
                    $myHP = $myHP - $ennemyStrength;

                if ($myHP <= 0) {
                    $fight = false;
                    $dead = 100 - (($ennemyHP * 100) / ($ennemyEndurance * 10));
                    FightService::loose($myArmy, $dead, $enemyArmy);
                    MessageService::sendMessage($user, $enemy, $bananas, $field, $dead, 'loose');

                    return back()->with('success', 'Vous avez perdu toute votre armée. GGWP');
                }

                if ($ennemyHP <= 0) {
                    $fight = false;
                    $dead = round(100 - (($myHP * 100) / ($myEndurance * 10)));
                    FightService::win($myArmy, $dead, $enemyArmy);
                    FightService::loot($enemy, $bananas, $field);
                    MessageService::sendMessage($user, $enemy, $bananas, $field, $dead, 'win');

                    return back()->with('success', 'Vous avez gagnez la bataille, mais vous avez perdu ' . $dead . '% de votre armée.');
                }

            }
        } else {

            while ($fight) {
                $myHP = $myHP - $ennemyStrength;
                if ($myHP > 0)
                    $ennemyHP = $ennemyHP - $myStrength;

                if ($myHP <= 0) {
                    $fight = false;
                    $dead = round(100 - (($ennemyHP * 100) / ($ennemyEndurance * 10)));
                    FightService::loose($myArmy, $dead, $enemyArmy);
                    MessageService::sendMessage($user, $enemy, $bananas, $field, $dead, 'loose');

                    return back()->with('success', 'Vous avez perdu toute votre armée. GGWP');
                }

                if ($ennemyHP <= 0) {
                    $fight = false;
                    $dead = round(100 - (($myHP * 100) / ($myEndurance * 10)));
                    FightService::win($myArmy, $dead, $enemyArmy);
                    FightService::loot($enemy, $bananas, $field);
                    MessageService::sendMessage($user, $enemy, $bananas, $field, $dead, 'win');

                    return back()->with('success', 'Vous avez gagnez la bataille, mais vous avez perdu ' . $dead . '% de votre armée.');
                }

            }
        }
    }

    private static function win($myArmy, $dead, $enemyArmy)
    {
        if ($dead > 0) {
            foreach ($myArmy as $unit) {
                if ($unit->unit->type != 'peon') {
                    $unit->units = $unit->units - ($unit->units * ($dead / 100));
                    $unit->touch();
                    FightService::upgrade($unit);
                }
            }
        }

        foreach ($enemyArmy as $unit) {
            if ($unit->unit->type != 'peon')
                $unit->delete();
        }
    }

    private static function loose($myArmy, $dead, $enemyArmy)
    {
        foreach ($myArmy as $unit) {
            if ($unit->unit->type != 'peon')
                $unit->delete();
        }

        if ($dead > 0) {
            foreach ($enemyArmy as $unit) {
                if ($unit->unit->type != 'peon') {
                    $unit->units = $unit->units - ($unit->units * ($dead / 100));
                    $unit->touch();
                    FightService::upgrade($unit);
                }
            }
        }
    }

    private static function loot($enemy, $bananas, $field)
    {
        $enemy->field->fields -= $field;
        $enemy->field->touch();
        $enemy->bananas -= $bananas;
        $enemy->touch();

        Auth::user()->field->fields += $field;
        Auth::user()->field->touch();
        Auth::user()->bananas += $bananas;
        Auth::user()->touch();

    }

    private static function upgrade($unit)
    {
        if ($unit->unit->upgrade) {
            $units = $unit->units;
            $type = $unit->unit->type;
            $level = $unit->unit->level;
            $user_id = $unit->user_id;

            $upgradeUnit = Unit::where(['type' => $type, 'level' => $level + 1])->first();

            $unit->delete();
            $unit = Unit_user::firstOrCreate([
                'unit_id' => $upgradeUnit->id,
                'user_id' => $user_id,
            ]);
            $unit->units = $units;
            $unit->user_id = $user_id;
            $unit->touch();
        }

    }


}