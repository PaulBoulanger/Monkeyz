<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
