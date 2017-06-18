<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
<<<<<<< HEAD
=======

>>>>>>> roles&permission
class Role extends Model
{
    use SoftDeletes;

    protected $guarded = [];
<<<<<<< HEAD
=======

    public function permissions()
    {
        return $this->belongsToMany('App\Permission','roles_permissions');
    }
>>>>>>> roles&permission
}
