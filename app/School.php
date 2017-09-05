<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class School extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $appends = ['logo'];

    public function logo()
    {
        return $this->belongsTo('App\File', 'logo_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function grades()
    {
        return $this->hasMany('App\Grade');
    }

    public function gradesWithTrashed()
    {
        return $this->hasMany('App\Grade')->withTrashed();
    }


    public function getLogoAttribute()
    {
        if ($this->logo_id)
            return Storage::disk('public')
                ->url($this->logo()->first()->filename);
        return null;
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function sections()
    {
        return $this->hasMany('App\Section')->select('id','name','grade_id','school_id');
    }

    public function years()
    {
        return $this->hasMany('App\Year');
    }

    public function checkUser($school_id,$user_id)
    {
        $check = $this->users()->where('school_id',$school_id)->where('user_id',$user_id)->first();
        if($check)
        {
            return $check;
        }
    }

    public function checkSection($school_id,$section_id)
    {
        $check = $this->sections()->where('id',$section_id)->where('school_id',$school_id)->first();
        if($check)
        {
            return $check;
        }

    }

    public function checkYear($school_id,$year_id)
    {
        $check = $this->years()->where('id',$year_id)->where('school_id',$school_id)->first();
        if($check)
        {
            return $check;
        }
    }

    public function getActiveYear()
    {
        $active = $this->years()->where('current',1)->first();
        if($active)
        {
            return $active;
        }
    }

}
