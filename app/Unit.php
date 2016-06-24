<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Unit extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function names()
    {
        return $this->hasMany('App\Unit_name');
    }

    public function name()
    {
        foreach ($this->names as $name) {
            if ($name->lang === env('LOCALE', 'en'))
                return $name->name;
        }
    }

    public function buildings()
    {
        return $this->belongsToMany('App\Building');
    }

    public function required()
    {
        $buildings = count($this->buildings);
        foreach ($this->buildings as $building) {
            foreach (Auth::user()->buildings as $userBuilding) {
                if ($userBuilding->id === $building->id)
                    $buildings--;
            }
            if ($buildings === 0)
                return true;
        }

        return false;
    }
}
