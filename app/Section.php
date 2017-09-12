<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function grade()
    {
        return $this->belongsTo('App\Grade')->withTrashed();
    }

    public function gradesWithTrashed()
    {
        return $this->belongsTo('App\Grade','grade_id')->withTrashed();
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
