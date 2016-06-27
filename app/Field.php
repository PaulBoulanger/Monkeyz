<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{

    protected $fillable = [
        'units_banana', 'units_wood',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
