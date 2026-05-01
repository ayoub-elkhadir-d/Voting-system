<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;

class PreventOwnerFromJoining
{
    public function handle(Request $request, Closure $next)
    {
        
        $room = $request->route('room');

        if (!$room instanceof Room) {
           
            if ($room) {
                $room = Room::find($room);
            }

         
            if (!$room && $request->has('d1')) {
                $code = implode('', [
                    $request->d1, $request->d2, $request->d3,
                    $request->d4, $request->d5, $request->d6,
                ]);
                $room = Room::where('code', $code)->first();
            }

        
            if (!$room && $request->has('room_id')) {
                $room = Room::find($request->room_id);
            }

           
            if (!$room && $request->route('code')) {
                $room = Room::where('code', $request->route('code'))->first();
            }
        }

        if ($room && $room->user_id === Auth::id()) {
  
            return redirect('/rooms/'.$room->id.'/start')
                ->with('error', 'You cannot join your own room as a voter.');
        }

        return $next($request);
    }
}
