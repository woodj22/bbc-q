<?php

namespace App\Listeners;

use App\Events\jobDone;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class jobDoneConfirmed
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
     * @param  jobDone  $event
     * @return void
     */
    public function handle(jobDone $event)
    {
        //
       // $event->;
    }
}
