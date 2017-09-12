<?php

namespace App\Listeners;

use App\Events\SchoolCreated;
use App\Year;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AttachYear
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
        $year = Year::create([
                'name'      => Carbon::now()->year,
                'current'   => true,
                'school_id' => $event->school->id
            ]);
    }
}
