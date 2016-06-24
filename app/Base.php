<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function strength()
    {
        $army = Unit_user::where('user_id', $this->user->id)->get();
        $strength = 0;
        foreach ($army as $unit) {
            $strength += $unit->unit->strength * $unit->units;
        }

        return $strength;
    }
}
