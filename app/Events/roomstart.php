<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class roomstart implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $roomId;
 
    public function __construct($room_id)
    {
      $this->roomId = $room_id;
      
    }

    
  public function broadcastOn(): array
{
    return [new Channel('room.' . $this->roomId)];
}


    public function broadcastAs()
    {
        return 'started.room';
    }
}
