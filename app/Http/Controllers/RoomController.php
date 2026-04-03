<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;

class RoomController extends Controller
{
    public function store(Request $r)
    {
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
                "Registration successful!"
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
    return view("Topic.create", [
        "data" => $room,
        "topics" => $room->topics
    ]);
}

}
