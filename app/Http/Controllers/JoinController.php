<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\UserJoined;
use App\Events\UserLeft;
use App\Models\Room;
use App\Models\membership;

class JoinController extends Controller
{
    // ── Private helpers ──────────────────────────────────────────────

    private function getMembership(int $roomId, int $userId)
    {
        return membership::where('room_id', $roomId)
            ->where('user_id', $userId)
            ->first();
    }

    private function acceptedCount(int $roomId): int
    {
        return membership::where('room_id', $roomId)
            ->where('status', 'accepted')
            ->count();
    }

    // ── Show join form ───────────────────────────────────────────────

    public function index()
    {
        return view('Room.join');
    }

    // ── Handle code entry (GET via link or POST via form) ────────────

    public function join(Request $request, $code = null)
    {
        if ($request->isMethod('post')) {
            $code = implode('', [
                $request->d1, $request->d2, $request->d3,
                $request->d4, $request->d5, $request->d6,
            ]);
        }

        $room = Room::where('code', $code)->first();

        if (!$room) {
            return redirect('/rooms/join')->with('error', 'Invalid room code!');
        }

        $isMember = $this->getMembership($room->id, Auth::id());

        if ($isMember) {
            if ($room->status === 'pending' && $isMember->status === 'accepted') {
                return redirect("/rooms/{$room->id}/vote");
            }

            return view('Room.waiting', [
                'user_name'   => $isMember->username,
                'room_id'     => $room->id,
                'total_users' => $this->acceptedCount($room->id),
            ]);
        }

        return view('Room.enter_username', ['room_id' => $room->id]);
    }

    // ── Confirm username and create membership ───────────────────────

    public function confirm(Request $request)
    {
        $request->validate([
            'room_id'   => 'required|exists:rooms,id',
            'user_name' => 'required|string|max:20|alpha_num',
        ]);

        $room   = Room::findOrFail($request->room_id);
        $status = $room->visibility === 'private' ? 'pending' : 'accepted';

        $nameTaken = membership::where('room_id', $request->room_id)
            ->where('username', $request->user_name)
            ->exists();

        if ($nameTaken) {
            return back()->with('error', 'This username is already taken!');
        }

        $isMember = $this->getMembership($request->room_id, Auth::id());

        if (!$isMember) {
            $isMember = membership::create([
                'room_id'  => $request->room_id,
                'user_id'  => Auth::id(),
                'username' => strip_tags($request->user_name),
                'role'     => 'user',
                'status'   => $status,
            ]);
        }

        broadcast(new UserJoined(
            $isMember->username,
            $request->room_id,
            $this->acceptedCount($request->room_id),
            $isMember->status,
            $isMember->id
        ));

        return $isMember->status === 'accepted'
            ? redirect("/rooms/{$request->room_id}/vote")
            : redirect("/rooms/{$request->room_id}/waiting");
    }

    // ── Waiting room ─────────────────────────────────────────────────

    public function waiting(Room $room)
    {
        $member = $this->getMembership($room->id, Auth::id());

        if (!$member) {
            return redirect('/rooms/join');
        }

        return view('Room.waiting', [
            'room_id'     => $room->id,
            'total_users' => $this->acceptedCount($room->id),
            'user_name'   => $member->username,
        ]);
    }

    // ── Leave room ───────────────────────────────────────────────────

    public function leave(Room $room)
    {
        $member = $this->getMembership($room->id, Auth::id());

        if ($member) {
            $member->delete();
            broadcast(new UserLeft($room->id, Auth::id()));
        }

        return redirect('/rooms/join');
    }
}
