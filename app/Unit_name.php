<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit_name extends Model
{
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}
