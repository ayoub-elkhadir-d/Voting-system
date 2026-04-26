<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Topic;
use App\Models\Vote;
use App\Models\membership;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId  = Auth::id();
        $roomIds = Room::where('user_id', $userId)->pluck('id');

        $totalRooms   = $roomIds->count();
        $totalTopics  = Topic::whereHas('room', fn($q) => $q->where('user_id', $userId))->count();
        $totalVotes   = Vote::whereIn('room_id', $roomIds)->count();
        $totalMembers = membership::whereIn('room_id', $roomIds)->count();
        $recentRooms  = Room::where('user_id', $userId)->latest()->take(5)->get();

        return view('Room.dashboard', compact(
            'totalRooms', 'totalTopics', 'totalVotes', 'totalMembers', 'recentRooms'
        ));
    }
}
