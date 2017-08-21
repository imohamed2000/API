<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'first_name', 'last_name',
        'email', 'password', 'gender',
        'address', 'phone', 'birth_date', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['name' , 'role'];

    public function schools()
    {
        return $this->belongsToMany('App\School');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function support_role(){
        return $this->hasOne('App\Support');
    }

    public function getRoleAttribute(){
        if($this->support_role){
            return $this->support_role->role;
        }
        return $this->roles()->where('user_id', $this->id)->first()->name;
    }

    public function getNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAvatarAttribute($value){
       return  Storage::disk('public')
                           ->url( \App\File::find($value)->filename );
    }
}
