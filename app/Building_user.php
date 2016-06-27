<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building_user extends Model
{
    protected $table = 'building_user';

    protected $fillable = [
        'building_id', 'user_id', 'finished_at',
    ];

    protected $dates = [
        'finished_at',
    ];
}
