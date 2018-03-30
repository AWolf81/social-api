<?php
namespace App\Events;

use App\Events\Event;
use App\Status;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewStatus extends Event implements ShouldBroadcast
{   
    use SerializesModels;

    public $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct(Status $status)
    {
        // Get status
        $this->status = $status;

    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */

    public function broadcastOn()
    {
        // return ['room_'.$this->message->room_id];
        return ['status_feed'];
    }

}