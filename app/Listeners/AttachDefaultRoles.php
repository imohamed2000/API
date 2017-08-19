<?php

namespace App\Listeners;

use App\Events\SchoolCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttachDefaultRoles
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SchoolCreated  $event
     * @return void
     */
    public function handle(SchoolCreated $event)
    {
        $moderator = [
            'name'      => 'Moderator',
            'school_id' => $event->school->id
        ];

        $student = [
            'name'      => 'Student',
            'school_id' => $event->school->id
        ];

        $parent = [
            'name'      => 'Parent',
            'school_id' => $event->school->id
        ];

        $teacher = [
            'name'      => 'Teacher',
            'school_id' => $event->school->id
        ];

        $default_roles = [$student, $parent, $moderator, $teacher];

        $roles = [];
        foreach($default_roles as $role){
            $role = \App\Role::create($role);
            $roles[] = [ 'id'   => $role->id, "name" => $role->name];
        }

        return $roles;
    }
}
