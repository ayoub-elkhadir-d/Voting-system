<?php
use Illuminate\Support\Facades\DB;

Broadcast::channel('room.{roomId}', function ($user, $roomId) {

    $member = DB::table('memberships')
        ->where('room_id', $roomId)
        ->where('user_id', $user->id)
        ->first();

   
    return $member && $member->status === 'accepted';
});