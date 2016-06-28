<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fight extends Model
{
    protected $fillable = [
        'user_id', 'enemy_id', 'fight_at',
    ];

    protected $dates = ['fight_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function timeFinished()
    {
        return $this->fight_at->format('m/d/Y H:i:s');
    }

    public function enemy()
    {
        $enemy = User::find($this->enemy_id);

        return $enemy->name;
    }
}
