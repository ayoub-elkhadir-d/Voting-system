<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Topic;
use App\Models\Vote;
use App\Models\membership;

class AdminController extends Controller
{
    public function show(Room $room)
    {
        $members = membership::where('room_id', $room->id)->get();

        $topics = Topic::where('room_id', $room->id)
            ->with(['choix' => fn($q) => $q->withCount([
                'votes as vote_count' => fn($q) => $q->where('room_id', $room->id),
            ])])
            ->whereIn('status', ['active', 'completed'])
            ->orderBy('updated_at')
            ->get();

        $completed = $topics->where('status', 'completed');
        $active    = $topics->firstWhere('status', 'active');
        $pending   = Topic::where('room_id', $room->id)->where('status', 'pending')->get();

        $stats = [
            'total_members'    => $members->count(),
            'total_topics'     => Topic::where('room_id', $room->id)->count(),
            'completed_topics' => $completed->count(),
            'total_votes'      => Vote::where('room_id', $room->id)->count(),
        ];

        $voteTimelines = [];
        foreach ($completed as $topic) {
            $voteTimelines[$topic->id] = Vote::where('topic_id', $topic->id)
                ->selectRaw("DATE_FORMAT(created_at, '%H:%i') as minute, COUNT(*) as cnt")
                ->groupBy('minute')
                ->orderBy('minute')
                ->get();
        }

        return view('Room.admin', compact(
            'room', 'topics', 'members', 'completed', 'active', 'pending', 'stats', 'voteTimelines'
        ));
    }
}
