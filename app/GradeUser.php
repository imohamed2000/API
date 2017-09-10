<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeUser extends Model
{
    protected $table = 'grade_user';

    public $timestamps = false;

    protected $guarded = [];
}
