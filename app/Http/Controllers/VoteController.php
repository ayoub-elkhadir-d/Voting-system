<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Topic;
use App\Models\Vote;
use App\Models\choix;
use App\Events\VoteUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function show(Room $room)
    {
        $activeTopic = Topic::where('room_id', $room->id)
            ->where('status', 'active')
            ->with('choix')
            ->first();

        $userVotedChoiceIds = [];
        $userVotedCount     = 0;

        if ($activeTopic) {
            $userVotedChoiceIds = Vote::where('user_id', Auth::id())
                ->where('topic_id', $activeTopic->id)
                ->pluck('choix_id')
                ->toArray();

            $userVotedCount = count($userVotedChoiceIds);
        }

        return view('Room.vote', compact(
            'room', 'activeTopic', 'userVotedCount', 'userVotedChoiceIds'
        ));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'choix_id' => 'required|exists:choixes,id',
            'room_id'  => 'required|exists:rooms,id',
        ]);

        $topic = Topic::findOrFail($request->topic_id);

        $votedCount = Vote::where('user_id', Auth::id())
            ->where('topic_id', $request->topic_id)
            ->count();

        if ($votedCount >= $topic->max_choices) {
            return response()->json(['status' => 'already_voted']);
        }

        $duplicate = Vote::where('user_id', Auth::id())
            ->where('topic_id', $request->topic_id)
            ->where('choix_id', $request->choix_id)
            ->exists();

        if ($duplicate) {
            return response()->json(['status' => 'duplicate_choice']);
        }

        Vote::create([
            'user_id'  => Auth::id(),
            'topic_id' => $request->topic_id,
            'choix_id' => $request->choix_id,
            'room_id'  => $request->room_id,
        ]);

        $choices = choix::where('topic_id', $request->topic_id)
            ->withCount(['votes as vote_count' => fn($q) => $q->where('room_id', $request->room_id)])
            ->get(['id', 'name']);

        broadcast(new VoteUpdated(
            $request->room_id,
            $request->topic_id,
            $choices->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'votes' => $c->vote_count])
        ));

        return response()->json(['status' => 'ok']);
    }
}
