<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Room;

class CheckRoomStarted
{
    public function handle(Request $request,  Closure $next)
    {
        
     
         if ($request->isMethod('post')) {
            $digits = [$request->d1, $request->d2, $request->d3, $request->d4, $request->d5, $request->d6];
            $code = implode('', $digits);
        }

        $room = Room::where('code', $code)->first();

        if (!$room) {
            return redirect('/rooms/join')->with('error', 'Invalid room code!');
        }
      
        $roomModel = $room instanceof Room ? $room : Room::find($room);

        if (!$roomModel) {
            return redirect()->back()->with('error', 'Room does not exist');
        }

       
   if ($room->status !== 'pending') {
    return response()->view('error', [
        'message' => 'Room is not active yet!'
    ]);
}
        return $next($request);
    }
}