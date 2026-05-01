<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Topic;
use App\Models\User;
use App\Models\Vote;

class SuperAdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'  => User::count(),
            'total_rooms'  => Room::count(),
            'total_topics' => Topic::count(),
            'total_votes'  => Vote::count(),
            'banned_users' => User::where('is_banned', true)->count(),
            'active_rooms' => Room::where('status', 'started')->count(),
        ];

        $users = User::withCount(['rooms'])->latest()->get();
        $rooms = Room::with('user')->withCount(['topics'])->latest()->get();

        return view('superadmin.dashboard', compact('stats', 'users', 'rooms'));
    }

    public function banUser(User $user)
    {
        $user->update(['is_banned' => true]);
        return back()->with('success', "User {$user->name} has been banned.");
    }

    public function unbanUser(User $user)
    {
        $user->update(['is_banned' => false]);
        return back()->with('success', "User {$user->name} has been unbanned.");
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function deleteRoom(Room $room)
    {
        $room->delete();
        return back()->with('success', 'Room deleted successfully.');
    }

    public function promoteUser(User $user)
    {
        $user->update(['role' => 'superadmin']);
        return back()->with('success', "{$user->name} promoted to Super Admin.");
    }

    public function demoteUser(User $user)
    {
        $user->update(['role' => 'user']);
        return back()->with('success', "{$user->name} demoted to User.");
    }
}
