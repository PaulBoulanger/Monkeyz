<?php

namespace App\Services;

class FightService
{

    public static function fight($myArmy, $ennemyArmy)
    {
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

        foreach ($ennemyArmy as $unit) {
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
                    FightService::loose($myArmy, $dead, $ennemyArmy);

                    return back()->with('success', 'Vous avez perdu toute votre armée. GGWP');
                }

                if ($ennemyHP <= 0) {
                    $fight = false;
                    $dead = 100 - (($myHP * 100) / ($myEndurance * 10));
                    FightService::win($myArmy, $dead, $ennemyArmy);

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
                    $dead = 100 - (($ennemyHP * 100) / ($ennemyEndurance * 10));
                    FightService::loose($myArmy, $dead, $ennemyArmy);

                    return back()->with('success', 'Vous avez perdu toute votre armée. GGWP');
                }

                if ($ennemyHP <= 0) {
                    $fight = false;
                    $dead = 100 - (($myHP * 100) / ($myEndurance * 10));
                    FightService::win($myArmy, $dead, $ennemyArmy);

                    return back()->with('success', 'Vous avez gagnez la bataille, mais vous avez perdu ' . $dead . '% de votre armée.');
                }

            }
        }
    }

    private static function win($myArmy, $dead, $ennemyArmy)
    {
        if ($dead > 0) {
            foreach ($myArmy as $unit) {
                if ($unit->unit->type != 'peon')
                    $unit->units = $unit->units - ($unit->units * ($dead / 100));
                $unit->touch();
            }
        }

        foreach ($ennemyArmy as $unit) {
            if ($unit->unit->type != 'peon')
                $unit->delete();
        }
    }

    private static function loose($myArmy, $dead, $ennemyArmy)
    {
        foreach ($myArmy as $unit) {
            if ($unit->unit->type != 'peon')
                $unit->delete();
        }

        if ($dead > 0) {
            foreach ($ennemyArmy as $unit) {
                if ($unit->unit->type != 'peon')
                    $unit->units = $unit->units - ($unit->units * ($dead / 100));
                $unit->touch();
            }
        }
    }


}