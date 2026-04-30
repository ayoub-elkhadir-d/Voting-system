<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Topic;
use App\Models\choix;
use App\Events\TopicStarted;
use App\Events\TopicEnded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    // ── Edit ─────────────────────────────────────────────────────────

    public function edit(Room $room, Topic $topic)
    {
        return view('Topic.update', [
            'room'   => $room,
            'topic'  => $topic,
            'topics' => $room->topics,
            'choixes'=> $topic->choix()->get(),
        ]);
    }

    // ── Create ───────────────────────────────────────────────────────

    public function store(Request $r, Room $room)
    {
        $r->validate([
            'topic_name' => 'required|string|max:255',
            'duration'   => 'required',
            'choices'    => 'required|array|min:1',
        ]);

        $topic = Topic::create([
            'name'         => $r->topic_name,
            'duration'     => $r->duration,
            'vote_methode' => $r->vote_method,
            'max_choices'  => $r->vote_method === 'select_multiple' ? (int) $r->max_choices : 1,
            'user_id'      => Auth::id(),
            'room_id'      => $room->id,
        ]);

        $now = now();
        choix::insert(array_map(fn($name) => [
            'name'       => $name,
            'room_id'    => $room->id,
            'topic_id'   => $topic->id,
            'created_at' => $now,
            'updated_at' => $now,
        ], $r->choices));

        return redirect()->to(session('return_url') ?? route('room.show', $room->id));
    }

    // ── Update ───────────────────────────────────────────────────────

    public function update(Request $r, Room $room, string $id)
    {
        $r->validate([
            'topic_name' => 'required|string|max:255',
            'duration'   => 'required',
            'choices'    => 'required|array|min:1',
        ]);

        $topic = Topic::findOrFail($id);

        $topic->update([
            'name'         => $r->topic_name,
            'duration'     => $r->duration,
            'vote_methode' => $r->vote_method,
            'max_choices'  => $r->vote_method === 'select_multiple' ? (int) $r->max_choices : 1,
        ]);

        choix::where('topic_id', $id)->delete();

        $now = now();
        choix::insert(array_map(fn($name) => [
            'name'       => trim($name),
            'topic_id'   => $id,
            'room_id'    => $room->id,
            'created_at' => $now,
            'updated_at' => $now,
        ], array_filter($r->choices, fn($c) => trim($c) !== '')));

        return redirect("/rooms/{$room->id}/topics/{$id}/edit")->with('success', 'Topic updated successfully!');
    }

    // ── Destroy ───────────────────────────────────────────────────────

    public function destroy(Room $room, Topic $topic)
    {
        choix::where('topic_id', $topic->id)->delete();
        $topic->delete();
        return redirect()->route('room.show', $room->id)->with('success', 'Topic deleted successfully!');
    }

    // ── Lifecycle ────────────────────────────────────────────────────

    public function start(Room $room, Topic $topic)
    {
        Topic::where('room_id', $room->id)
            ->where('status', 'active')
            ->update(['status' => 'completed']);

        $topic->status     = 'active';
        $topic->started_at = now();
        $topic->save();
        $topic->load('choix');

        broadcast(new TopicStarted($room->id, [
            'id'           => $topic->id,
            'name'         => $topic->name,
            'duration'     => $topic->duration,
            'started_at'   => strtotime($topic->started_at),
            'vote_methode' => $topic->vote_methode,
            'max_choices'  => $topic->max_choices,
            'choices'      => $topic->choix->map(fn($c) => ['id' => $c->id, 'name' => $c->name]),
        ]));

        return back();
    }

    public function stop(Room $room, Topic $topic)
    {
        $topic->status = 'completed';
        $topic->save();

        broadcast(new TopicEnded($room->id, $topic->id));

        return back();
    }

    public function restart(Room $room, Topic $topic)
    {
        $topic->status     = 'pending';
        $topic->started_at = null;
        $topic->save();

        return back();
    }

    // ── API ──────────────────────────────────────────────────────────

    public function votes(Room $room, Topic $topic)
    {
        $choices = $topic->choix()
            ->withCount(['votes as vote_count' => fn($q) => $q->where('room_id', $room->id)])
            ->get(['id', 'name']);

        return response()->json($choices->map(fn($c) => [
            'id'    => $c->id,
            'name'  => $c->name,
            'votes' => $c->vote_count,
        ]));
    }

    public function all(Room $room)
    {
        return response()->json($room->topics);
    }
}
