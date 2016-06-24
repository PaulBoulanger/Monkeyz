<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'bananas', 'lastIncome',
    ];

    protected $dates = [
        'lastIncome',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function units()
    {
        return $this->belongsToMany('App\Unit');
    }

    public function resource()
    {
        return $this->belongsTo('App\Resource');
    }

    public function buildings()
    {
        return $this->belongsToMany('App\Building');
    }

    public function field()
    {
        return $this->hasOne('App\Field');
    }

    public function lastIncome()
    {
        return $this->lastIncome->addHour(1);
    }

    public function income()
    {
        return round($this->field->units / 5);
    }

    public function getIncome()
    {
        $now = Carbon::now();
        $lastIncome = $this->lastIncome;
        $hours = $now->diffInHours($lastIncome);

        if ($hours >= 1) {
            $this->lastIncome = $lastIncome->addHour($hours);
            $this->bananas += $this->income() * $hours;
            $this->touch();
        }
    }

}
