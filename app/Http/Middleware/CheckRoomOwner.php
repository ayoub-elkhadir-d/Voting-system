<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;

class CheckRoomOwner
{
    public function handle(Request $request, Closure $next)
    {
        $room = $request->route('room');

        if (!$room) {
            return redirect('/myrooms');
        }

        if ($room instanceof Room) {
            $roomModel = $room;
        } else {
            $roomModel = Room::find($room);
        }

        if (!$roomModel) {
            return redirect('/myrooms');
        }

        if ($roomModel->user_id != Auth::id()) {
            return redirect('/myrooms');
        }

        return $next($request);
    }
}