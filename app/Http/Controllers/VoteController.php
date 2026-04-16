<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Topic;
use App\Models\choix;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function show(Room $room)
    {
        $topics = Topic::where('room_id', $room->id)
            ->with('choix')
            ->get()
            ->map(function ($topic) {
                $parts = explode(':', $topic->duration);
                $topic->duration_seconds = (int)$parts[0] * 3600 + (int)$parts[1] * 60 + (int)$parts[2];
                return $topic;
            });
      

        return view('Room.vote', compact('room', 'topics'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'choix_id' => 'required|exists:choixes,id',
            'room_id'  => 'required|exists:rooms,id',
        ]);

        // prevent double voting on same topic
        $already = DB::table('votes')
            ->where('user_id', Auth::id())
            ->where('topic_id', $request->topic_id)
            ->exists();

        if (!$already) {
            DB::table('votes')->insert([
                'user_id'    => Auth::id(),
                'topic_id'   => $request->topic_id,
                'choix_id'   => $request->choix_id,
                'room_id'    => $request->room_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
public function start(Room $room)
{

    return redirect()->back(); 
}
}
