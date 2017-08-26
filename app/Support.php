<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'support_users';
    protected $fillable = ['user_id', 'role'];
    public $timestamps = false;

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
