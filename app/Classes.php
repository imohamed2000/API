<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use SoftDeletes;

    protected $table = 'classes';

    protected $guarded = [];

    public function sections()
    {
        return $this->hasMany('App\Section','class_id');
    }
}
