<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Beak\QueryFilter;

class Role extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission','roles_permissions');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'role_user', 'role_id', 'user_id');
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
