<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use softDeletes;

    protected $fillable = ['name', 'school_id', 'order'];
    protected $dates = ['deleted_at'];


    public function school()
    {
        return $this->belongsTo('App\School');
    }

    public function sections(){
    	return $this->hasMany('\App\Section');
    }

    public function users(){
        return $this->belongsToMany('\App\User');
    }
}
