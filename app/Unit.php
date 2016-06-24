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

    public function names()
    {
        return $this->hasMany('App\Unit_name');
    }

    public function name()
    {
        foreach ($this->names as $name) {
            if ($name->lang === env('LOCALE', 'en'))
                return $name->name;
        }
    }
}
