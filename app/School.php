<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $guarded = [];


    public function logo()
    {
        return $this->belongsTo('App\File','logo_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User','school_users');

    }
}
