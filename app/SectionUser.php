<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionUser extends Model
{
    protected $table = 'section_user';

    public $timestamps = false;

    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo('App\Section','section_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
