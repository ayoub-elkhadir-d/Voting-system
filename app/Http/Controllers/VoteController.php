<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Topic;
use App\Models\choix;
use App\Models\membership;
use App\Events\TopicEnded;
use App\Events\TopicStarted;
use App\Events\VoteUpdated;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function show(Room $room)
    {
        $topics = Topic::where('room_id', $room->id)->with('choix')->get();

        $activeTopic = $topics->firstWhere('status', 'active');
        if ($activeTopic) {
            $activeTopic->load('choix');
        }

        $userVotedCount = 0;
        $userVotedChoiceIds = [];
        if ($activeTopic) {
            $userVotes = DB::table('votes')
                ->where('user_id', Auth::id())
                ->where('topic_id', $activeTopic->id)
                ->pluck('choix_id');
            $userVotedCount     = $userVotes->count();
            $userVotedChoiceIds = $userVotes->toArray();
        }

        return view('Room.vote', compact('room', 'topics', 'activeTopic', 'userVotedCount', 'userVotedChoiceIds'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'choix_id' => 'required|exists:choixes,id',
            'room_id'  => 'required|exists:rooms,id',
        ]);

        $topic = Topic::find($request->topic_id);

        // Count user votes
        $votedCount = DB::table('votes')
            ->where('user_id', Auth::id())
            ->where('topic_id', $request->topic_id)
            ->count();

      
        if ($votedCount >= $topic->max_choices) {
            return response()->json(['status' => 'already_voted']);
        }

        // Block duplicate choice 
        $alreadyThisChoice = DB::table('votes')
            ->where('user_id', Auth::id())
            ->where('topic_id', $request->topic_id)
            ->where('choix_id', $request->choix_id)
            ->exists();

        if ($alreadyThisChoice) {
            return response()->json(['status' => 'duplicate_choice']);
        }

        DB::table('votes')->insert([
            'user_id'    => Auth::id(),
            'topic_id'   => $request->topic_id,
            'choix_id'   => $request->choix_id,
            'room_id'    => $request->room_id,
            'created_at' => now(),
            'updated_at' => now(),
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


public function adminShow(Room $room)
{ 
    $members = membership::where('room_id', $room->id)->get();

    $topics = Topic::where('room_id', $room->id)
        ->with(['choix' => function ($q) use ($room) {
            $q->withCount(['votes as vote_count' => function ($q) use ($room) {
                $q->where('room_id', $room->id);
            }]);
        }])
        ->whereIn('status', ['active', 'completed'])
        ->orderBy('updated_at')
        ->get();

    $completed = $topics->where('status', 'completed');
    $active    = $topics->firstWhere('status', 'active');
    $pending   = Topic::where('room_id', $room->id)
                    ->where('status', 'pending')
                    ->get();

    $stats = [
        'total_members'    => $members->count(),
        'total_topics'     => Topic::where('room_id', $room->id)->count(),
        'completed_topics' => $completed->count(),
        'total_votes'      => DB::table('votes')->where('room_id', $room->id)->count(),
    ];

    return view('Room.admin', compact('room', 'topics', 'members', 'completed', 'active', 'pending', 'stats'));
}

public function stopTopic(Room $room, Topic $topic)
{
    $topic->status = 'completed';
    $topic->save();

    broadcast(new TopicEnded($room->id, $topic->id));

    return back();
}

public function startTopic(Room $room, Topic $topic)
{
    Topic::where('room_id', $room->id)->where('status', 'active')->update(['status' => 'completed']);

    $topic->status = 'active';
    $topic->started_at = now();
    $topic->save();
    $topic->load('choix');

    broadcast(new TopicStarted($room->id, [
        'id'          => $topic->id,
        'name'        => $topic->name,
        'duration'    => $topic->duration,
        'started_at'  => strtotime($topic->started_at),
        'vote_methode'=> $topic->vote_methode,
        'max_choices' => $topic->max_choices,
        'choices'     => $topic->choix->map(fn($c) => ['id' => $c->id, 'name' => $c->name]),
    ]));

    return back();
}

public function topicVotes(Room $room, Topic $topic)
{
    $choices = $topic->choix()->withCount(['votes as vote_count' => function ($q) use ($room) {
        $q->where('room_id', $room->id);
    }])->get(['id', 'name']);

    return response()->json($choices->map(fn($c) => [
        'id'    => $c->id,
        'name'  => $c->name,
        'votes' => $c->vote_count,
    ]));
}
}
