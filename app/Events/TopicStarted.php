<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TopicStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomId;
    public $topic;

    public function __construct($roomId, $topic)
    {
        $this->roomId = $roomId;
        $this->topic  = $topic;
    }

    public function broadcastOn(): array
    {
        return [new Channel('room.' . $this->roomId)];
    }

    public function broadcastAs()
    {
        return 'topic.started';
    }
}
