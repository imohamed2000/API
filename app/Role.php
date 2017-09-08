<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    private $default_role_slugs = ['student', 'parent', 'moderator', 'teacher'];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission','roles_permissions');
    }

    public function schools(){
    	return $this->belongsToMany('\App\School');
    }

    /**
     * Sets the default value of the role slug to a random string if it was not one of the default slugs
     * @param string $value 
     */
    public function setSlugAttribute($value){
    	if(!in_array($value, $this->default_role_slugs)){
    		$value = str_random(9);
    	}
    	$this->attributes['slug'] = strtolower($value);
    }
}
