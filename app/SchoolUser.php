<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolUser extends Model
{
    protected $table = 'school_users';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
