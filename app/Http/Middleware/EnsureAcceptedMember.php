<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EnsureAcceptedMember
{
    public function handle(Request $request, Closure $next)
    {
        $roomId = $request->route('room');

        $member = DB::table('memberships')
            ->where('room_id', $roomId->id)
            ->where('user_id', Auth::id())
            ->first();

       
        if (!$member) {
            return redirect('/rooms/join');
        }

        
        if ($member->status !== 'accepted') {
            return redirect('/rooms/join')
                ->with('error', 'You are not approved yet.');
        }

        return $next($request);
    }
}