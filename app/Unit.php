<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
