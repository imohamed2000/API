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
        return $this->hasMany('App\Section')->select('id','name','grade_id');
    }

    public function years()
    {
        return $this->hasMany('App\Year');
    }
}
