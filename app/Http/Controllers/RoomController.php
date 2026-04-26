<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\membership;
use App\Events\RoomStart;
use App\Events\UserJoined;
use App\Events\UserRemoved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    // ── Private helpers ──────────────────────────────────────────────

    private function acceptedCount(int $roomId): int
    {
        return membership::where('room_id', $roomId)
            ->where('status', 'accepted')
            ->count();
    }

    // ── Room CRUD ────────────────────────────────────────────────────

    public function store(Request $r)
    {
        $r->validate([
            'room_name'    => 'required|max:255',
            'room_desc'    => 'required',
            'member_type'  => 'required',
            'member_limit' => 'required|integer|min:1',
            'visibility'   => 'required|in:public,private',
            'vote_method'  => 'required',
        ]);

        Room::create([
            'name'         => $r->room_name,
            'code'         => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            'description'  => $r->room_desc,
            'user_id'      => Auth::id(),
            'member_limit' => $r->member_limit,
            'visibility'   => $r->visibility,
            'vote_method'  => $r->vote_method,
        ]);

        return redirect('/roomcreate')->with('success', 'Room created successfully!');
    }

    public function rooms()
    {
        $rooms = Room::where('user_id', Auth::id())->get();
        return view('Room/myrooms', ['rooms' => $rooms]);
    }

    public function show(Room $room)
    {
        session(['return_url' => request('from')]);
        return view('Topic.create', ['data' => $room, 'topics' => $room->topics]);
    }

    public function edit($id)
    {
        return view('Room/update', ['data' => Room::findOrFail($id)]);
    }

    public function update($id, Request $r)
    {
        $r->validate([
            'room_name'    => 'required|max:255',
            'room_desc'    => 'required',
            'member_limit' => 'required|integer|min:1',
            'visibility'   => 'required|in:public,private',
            'vote_method'  => 'required',
        ]);

        Room::findOrFail($id)->update([
            'name'         => $r->room_name,
            'description'  => $r->room_desc,
            'member_limit' => $r->member_limit,
            'visibility'   => $r->visibility,
            'vote_method'  => $r->vote_method,
        ]);

        return redirect('/myrooms')->with('success', 'Room updated successfully!');
    }

    public function delete($id)
    {
        Room::findOrFail($id)->delete();
        return redirect('/myrooms')->with('success', 'Room deleted successfully!');
    }

    // ── Room session ─────────────────────────────────────────────────

    public function start(Room $room_id)
    {
        $room_id->status = 'pending';
        $room_id->save();

        return view('Room.code', [
            'rawCode'   => $room_id->code,
            'codeArray' => str_split($room_id->code),
            'room_id'   => $room_id->id,
            'room'      => $room_id,
            'members'   => membership::where('room_id', $room_id->id)->get(),
        ]);
    }

    public function broadcastRoom(Room $room)
    {
        broadcast(new RoomStart($room->id));
        return redirect("/rooms/{$room->id}/admin");
    }



    public function removeUser(Room $room, membership $member)
    {
        $userId = $member->user_id;
        $member->delete();

        broadcast(new UserRemoved($userId, $room->id));

        return back();
    }

    public function approveUser(Room $room, membership $member)
    {
        $member->status = 'accepted';
        $member->save();

        broadcast(new UserJoined(
            $member->username,
            $room->id,
            $this->acceptedCount($room->id),
            $member->status,
            $member->id
        ));

        return back();
    }
}
