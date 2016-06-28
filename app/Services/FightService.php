<?php

namespace App\Services;

use App\Unit;
use App\User;
use App\Fight;
use App\Unit_user;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FightService
{

    public static function go($user, $enemy)
    {

        if ($fight = Fight::where('user_id', $user->id)->first())
            return back()->with('error', 'Vous êtes déjà parti en guerre !');

        $user_x = $user->base->position_x;
        $user_y = $user->base->position_y;

        $enemy_x = $enemy->base->position_x;
        $enemy_y = $enemy->base->position_y;

        $x = $user_x - $enemy_x;
        $y = $user_y - $enemy_y;

        $x = ($x < 0) ? $x * -1 : $x;
        $y = ($y < 0) ? $y * -1 : $y;

        $distance = ($x + $y) / 2;
        $time = 120 * $distance;

        Fight::create([
            'user_id' => $user->id,
            'enemy_id' => $enemy->id,
            'fight_at' => Carbon::now()->addSeconds($time),
        ]);

        return back()->with('success', "Vous allez tenter de piller le bananier de $enemy->name, le combat aura lieu dans $time secondes");
    }

    public static function checkFight($user)
    {
        $fight = Fight::where('user_id', $user->id)->first();

        if ($fight && Carbon::now() >= $fight->fight_at) {
            $enemy = User::find($fight->enemy_id);

            return FightService::fight($user, $enemy);
        }
    }

    private
    static function fight($user, $enemy)
    {

        Fight::where('user_id', $user->id)->delete();

        $myArmy = Unit_user::where('user_id', $user->id)->get();
        $enemyArmy = Unit_user::where('user_id', $enemy->id)->get();

        $bananas = $enemy->bananas / 2;
        $field = $enemy->field->fields / 2;

        $myEndurance = 0;
        $myStrength = 0;
        $myAgility = 0;

        $enemyEndurance = 0;
        $enemyStrength = 0;
        $enemyAgility = 0;

        foreach ($myArmy as $unit) {
            $myEndurance += $unit->unit->endurance * $unit->units;
            $myStrength += $unit->unit->strength * $unit->units;
            $myAgility += $unit->unit->agility * $unit->units;
        }

        foreach ($enemyArmy as $unit) {
            $enemyEndurance += $unit->unit->endurance * $unit->units;
            $enemyStrength += $unit->unit->strength * $unit->units;
            $enemyAgility += $unit->unit->agility * $unit->units;
        }

        $myHP = $myEndurance * 10;
        $enemyHP = $enemyEndurance * 10;
        $fight = true;

        if ($myAgility > $enemyAgility) {

            while ($fight) {
                $enemyHP = $enemyHP - $myStrength;
                if ($enemyHP > 0)
                    $myHP = $myHP - $enemyStrength;

                if ($myHP <= 0) {
                    $fight = false;
                    $dead = 100 - (($enemyHP * 100) / ($enemyEndurance * 10));
                    FightService::loose($myArmy, $dead, $enemyArmy);
                    MessageService::sendMessage($user, $enemy, $bananas, $field, $dead, 'loose');

                    return back()->with('success', 'Vous avez perdu toute votre armée. GGWP');
                }

                if ($enemyHP <= 0) {
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
                $myHP = $myHP - $enemyStrength;
                if ($myHP > 0)
                    $enemyHP = $enemyHP - $myStrength;

                if ($myHP <= 0) {
                    $fight = false;
                    $dead = round(100 - (($enemyHP * 100) / ($enemyEndurance * 10)));
                    FightService::loose($myArmy, $dead, $enemyArmy);
                    MessageService::sendMessage($user, $enemy, $bananas, $field, $dead, 'loose');

                    return back()->with('success', 'Vous avez perdu toute votre armée. GGWP');
                }

                if ($enemyHP <= 0) {
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

    private
    static function win($myArmy, $dead, $enemyArmy)
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

    private
    static function loose($myArmy, $dead, $enemyArmy)
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

    private
    static function loot($enemy, $bananas, $field)
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

    private
    static function upgrade($unit)
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