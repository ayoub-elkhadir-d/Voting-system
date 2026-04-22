<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\Topic;
use Livewire\Attributes\On;

class SidebarTopics extends Component
{
    public $roomId;

    public function mount($roomId)
    {
        $this->roomId = $roomId;
    }

    public function restart($topicId)
    {
        $topic = Topic::where('room_id', $this->roomId)->where('id', $topicId)->first();

        if ($topic) {
            $topic->status = 'pending';
            $topic->started_at = null;
            $topic->save();
        }
    }

    #[On('restart-topic')]
    public function restartTopic($topicId)
    {
        $this->restart($topicId);
    }

    public function render()
    {
        $room = Room::find($this->roomId);
        $active = Topic::where('room_id', $this->roomId)->where('status', 'active')->first();
        $pending = Topic::where('room_id', $this->roomId)->where('status', 'pending')->get();

        return view('livewire.sidebar-topics', compact('room', 'active', 'pending'));
    }
}
