<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Jobs\SendEmail;

class jobDone extends Event
{
    use SerializesModels;



    public $email;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SendEmail $sendEmail)
    {
        //
        $this->email = $sendEmail;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
