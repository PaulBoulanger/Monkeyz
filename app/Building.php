<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Building extends Model
{

    protected $dates = [
        'finished_at',
    ];

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

    public function requireTime()
    {
        $minute = round($this->time / 60);
        return $minute . ' ' . trans_choice('site.minutes', $minute);
    }

    public function timeFinished(User $user)
    {
        $building_user = Building_user::where(['user_id' => $user->id, 'building_id' => $this->id])->first();

        return $building_user->finished_at->format('m/d/Y H:i:s');
    }

}
