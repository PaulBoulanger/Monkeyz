<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit_user extends Model
{
    protected $table = "unit_user";

    protected $fillable = ['unit_id', 'user_id', 'units'];

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
