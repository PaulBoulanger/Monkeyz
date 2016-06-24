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

                    return back()->with('success', 'Vous avez perdu');
                }

                if ($ennemyHP <= 0) {
                    $fight = false;

                    return back()->with('success', 'Vous avez gagnez');
                }

            }
        } else {

            while ($fight) {
                $myHP = $myHP - $ennemyStrength;
                if ($myHP > 0)
                    $ennemyHP = $ennemyHP - $myStrength;

                if ($myHP <= 0) {
                    $fight = false;

                    return back()->with('success', 'Vous avez perdu');
                }

                if ($ennemyHP <= 0) {
                    $fight = false;

                    return back()->with('success', 'Vous avez gagnez');
                }

            }
        }
    }

}