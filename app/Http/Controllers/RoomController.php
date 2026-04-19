<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\UserJoined;
use App\Models\Room;
use App\Models\membership;

class RoomController extends Controller
{
    public function store(Request $r)
    {
        $fakeNumber = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $data = $r->validate([
            "room_name"    => "required|max:255",
            "room_desc"    => "required",
            "member_type"  => "required",
            "member_limit" => "required|integer",
            "visibility"   => "required",
            "vote_method"  => "required",
        ]);

        if ($data) {
            DB::table("rooms")->insert([
                "name"         => $r->room_name,
                "code"         => $fakeNumber,
                "description"  => $r->room_desc,
                "user_id"      => Auth::id(),
                "member_limit" => $r->member_limit,
                "visibility"   => $r->visibility,
                "vote_method"  => $r->vote_method,
                "created_at"   => now(),
                "updated_at"   => now(),
            ]);
            return redirect("/roomcreate")->with("success", "Registration successful !!");
        }
        return;
    }

    public function rooms()
    {
        $rooms = Room::where("user_id", Auth::id())->get();
        return view("Room/myrooms", ["rooms" => $rooms]);
    }

    public function delete($id)
    {
        Room::find($id)->delete();
        return redirect("/myrooms")->with("success", "successful! deleted");
    }

    public function update($id, Request $r)
    {
        $room = Room::find($id);
        $room->name         = $r->room_name;
        $room->description  = $r->room_desc;
        $room->member_limit = $r->member_limit;
        $room->visibility   = $r->visibility;
        $room->vote_method  = $r->vote_method;
        $room->updated_at   = now();
        $room->save();
        return redirect("/myrooms")->with("success", "Update successful!");
    }

    public function show(Room $room)
    {
        return view("Topic.create", ["data" => $room, "topics" => $room->topics]);
    }

    public function start(Room $room_id)
    {
        $members = membership::where('room_id', $room_id->id)->get();
        $room = Room::find($room_id->id);
        $room->status = "pending";
        $room->save();

        return view('Room.code', [
            "rawCode"   => $room_id->code,
            "codeArray" => str_split($room_id->code),
            "room_id"   => $room_id->id,
            'members' => $members,
        ]);
    }

    public function get_join()
    {
        return view('Room.join');
    }


    public function join(Request $request, $code = null)
    {
        if ($request->isMethod('post')) {
            $digits = [$request->d1, $request->d2, $request->d3, $request->d4, $request->d5, $request->d6];
            $code = implode('', $digits);
        }

        $room = Room::where('code', $code)->first();

        if (!$room) {
            return redirect('/rooms/join')->with('error', 'Invalid room code!');
        }

        $isMember = DB::table('memberships')
            ->where('room_id', $room->id)
            ->where('user_id', Auth::id())
            ->first();

   if ($isMember) {

       if($isMember && $room->status === 'pending'){
                return redirect("/rooms/{$room->id}/vote");
            }
            else{
               $count = membership::where('room_id', $room->id)->count();
                return view('Room.waiting', [
                    'user_name'   => $isMember->username,
                    'room_id'     => $room->id,
                    'total_users' => $count,
                ]);
            }
        }

        return view('Room.enter_username', ['room_id' => $room->id]);
    }

    public function join_confirm(Request $request)
    {
        $request->validate([
            'room_id'   => 'required',
            'user_name' => 'required|string|max:20',
        ]);

        $nameTaken = DB::table('memberships')
            ->where('room_id', $request->room_id)
            ->where('username', $request->user_name)
            ->exists();

        if ($nameTaken) {
            return back()->with('error', 'This username is already taken!');
        }

        $isMember = DB::table('memberships')
            ->where('room_id', $request->room_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$isMember) {
            DB::table('memberships')->insert([
                'room_id'    => $request->room_id,
                'user_id'    => Auth::id(),
                'username'   => $request->user_name,
                'role'       => 'user',
                'status'     => 'active',
                'created_at' => now(),
            ]);
        }

        $participantsCount = membership::where('room_id', $request->room_id)->count();
        
        broadcast(new UserJoined($request->user_name, $request->room_id, $participantsCount));

        return view('Room.waiting', [
            'room_id'     => $request->room_id,
            'total_users' => $participantsCount,
            'user_name'   => $request->user_name,

        ]);
    }

    public function left_room($room_id)
    {
        membership::where('user_id', Auth::id())->delete();
        return redirect('/rooms/join');
    }
    public function removeUser($roomId, $userId)
{
    membership::where('room_id', $roomId)
        ->where('id', $userId)
        ->delete();

    return back();
}
}
