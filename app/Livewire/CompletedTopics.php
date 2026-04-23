<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class CompletedTopics extends Component
{
    public $roomId;

    public function mount($roomId)
    {
        $this->roomId = $roomId;
    }

    #[On('restart-topic')]
    public function restartTopic($topicId)
    {
        $topic = Topic::where('room_id', $this->roomId)->where('id', $topicId)->first();

        if ($topic) {
            $topic->status     = 'pending';
            $topic->started_at = null;
            $topic->save();
        }
    }

    public function render()
    {
        $completed = Topic::where('room_id', $this->roomId)
            ->where('status', 'completed')
            ->with(['choix' => function ($q) {
                $q->withCount(['votes as vote_count' => function ($q) {
                    $q->where('room_id', $this->roomId);
                }]);
            }])
            ->get();

        // votes grouped by minute for each completed topic
        $voteTimelines = [];
        foreach ($completed as $topic) {
            $voteTimelines[$topic->id] = DB::table('votes')
                ->where('topic_id', $topic->id)
                ->selectRaw("DATE_FORMAT(created_at, '%H:%i') as minute, COUNT(*) as cnt")
                ->groupBy('minute')
                ->orderBy('minute')
                ->get();
        }

        return view('livewire.completed-topics', compact('completed', 'voteTimelines'));
    }
}
