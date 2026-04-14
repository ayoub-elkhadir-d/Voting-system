<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\UserJoined;
use App\Models\Room;

class RoomController extends Controller
{
    public function store(Request $r)
    {
        $fakeNumber = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $data = $r->validate([
            "room_name" => "required|max:255",

            "room_desc" => "required",
            "member_type" => "required",
            "member_limit" => "required|integer",
            "visibility" => "required",
            "vote_method" => "required",
        ]);
        
        if ($data) {
            DB::table("rooms")->insert([
                "name" => $r->room_name,
                 "code" => $fakeNumber,
                "description" => $r->room_desc,
                "user_id" => Auth::id(),
                "member_limit" => $r->member_limit,
                "visibility" => $r->visibility,
                "vote_method" => $r->vote_method,
                "created_at" => now(),
                "updated_at" => now(),

            ]);
            return redirect("/roomcreate")->with(
                "success",
                "Registration successful !!"
            );
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
        $room = Room::find($id);
        $room->delete();
        return redirect("/myrooms")->with("success", "successful! deleted");
    }

    public function update($id, Request $r)
    {
        $room = Room::find($id);
        $room->name = $r->room_name;
        $room->description = $r->room_desc;
        $room->member_limit = $r->member_limit;
        $room->visibility = $r->visibility;
        $room->vote_method = $r->vote_method;
        $room->updated_at = now();
        $room->save();
        return redirect("/myrooms")->with("success", "Update successful!");
    }

    public function show(Room $room)
    {
        return view("Topic.create", ["data" => $room, "topics" => $room->topics]);
    }

public function start(Room $room_id) {

    $fakeNumber = $room_id->code;
     $room = Room::find($room_id->id);
    $room->status = "pending";
    $room->save();

    return view('Room.code', [
        "rawCode" => $fakeNumber, 
        "codeArray" => str_split($fakeNumber) ,
        "room_id" => $room_id->id
    ]);

    // return $room_id;
}
public function get_join(){
    return view('Room.join');
}


public function check_room(Request $request) {
    $data = $request->except('_token');
    ksort($data);
    $roomCode = implode('', $data);

    $room = Room::where('code', $roomCode)->first();
if($room){
     $isMember = DB::table("memberships")
        ->where("room_id", $room->id)
        ->where("user_id", Auth::id())
        ->first();
}else{
    return redirect("/rooms/join")->with("error", "Invalid room code!");
}

    if($isMember){
   
         return redirect("/rooms/waiting-participants")->with('user_name',$isMember->username)->with('room_id',$room->id);
    }
        // return dd($isMember);
   if($room && !$isMember) {
      return redirect("/rooms/{$room->id}/enter_username");
  } 

  
}

public function join_confirm(Request $request) {
    $request->validate([
        'room_id'   => 'required',
        'user_name' => 'required|string|max:20',
    ]);

    $nameTaken = DB::table("memberships")
        ->where("room_id", $request->room_id)
        ->where("username", $request->user_name)
        ->exists();

    if ($nameTaken) {
        return back()->with("error", "this username alredy taken !!!");
    }

    $isMember = DB::table("memberships")
        ->where("room_id", $request->room_id)
        ->where("user_id", Auth::id())
        ->exists();
    
    if (!$isMember) {
        DB::table("memberships")->insert([
            "room_id"    => $request->room_id,
            "user_id"    => Auth::id(),
            "username"   => $request->user_name,
            "role"       => "user",
            "status"     => "active",
            "created_at" => now(),
        ]);

       broadcast(new UserJoined($request->user_name, $request->room_id))->toOthers();

    }elseif($isMember){
        return redirect("/rooms/waiting-participants");
    }


    return redirect("/rooms/waiting-participants");
}
}
