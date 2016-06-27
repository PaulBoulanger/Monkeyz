<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recruit_user extends Model
{
    protected $table = "recruit_user";

    protected $fillable = ['unit_id', 'user_id', 'units', 'launched_at', 'finished_at'];

    protected $dates = ['launched_at', 'finished_at'];

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function requireTime()
    {
        $minute = round(($this->unit->time * $this->units) / 60);
        return $minute . ' ' . trans_choice('site.minutes', $minute);
    }
}
