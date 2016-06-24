<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Building extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function units()
    {
        return $this->belongsToMany('App\Unit');
    }

    public function userHasBuilding()
    {

        foreach (Auth::user()->buildings as $building) {
            if ($this->id === $building->id)
                return true;
        }

        return false;

    }
}
