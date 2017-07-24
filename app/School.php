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
        return $this->belongsTo('App\File','logo_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User','school_users');

    }
    public function classes()
    {
        return $this->hasMany('App\Classes','school_id');
    }

    public function getLogoAttribute(){
        if($this->logo_id)
            return Storage::disk('public')
                        ->url( $this->logo()->first()->filename );
        return null;
    }
}
