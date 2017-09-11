<?php

namespace App\Listeners;

use App\Events\SchoolCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttachDefaultRoles
{   
    private $default_roles;
    private $school;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->default_roles = ['Moderator', 'Student', 'Parent', 'Teacher'];
    }

    /**
     * Handle the event.
     *
     * @param  SchoolCreated  $event
     * @return void
     */
    public function handle(SchoolCreated $event)
    {   
        foreach($this->default_roles as $role_name){
            $attr = [
                'name'  => $role_name,
                'slug'  => str_slug($role_name)
            ];
            $role = \App\Role::create($attr);
            $role->schools()->attach($event->school->id);
            $roles[] = $role->toArray();
        }   
        return $roles;
    }
}
