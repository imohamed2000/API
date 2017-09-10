<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeUser extends Model
{
    protected $table = 'grade_user';

    public $timestamps = false;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
