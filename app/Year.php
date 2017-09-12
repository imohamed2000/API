<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Year extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $fillable = ['name', 'current', 'school_id'];
}
