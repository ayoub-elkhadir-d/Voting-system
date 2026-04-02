<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r,Room $room)
    {
        $data = $r->validate([
            "duration" => "required",
            "topic_name" => "required",
          
        ]);

         if ($data) {
            DB::table("topics")->insert([
                "name" => $r->topic_name,
                "duration"=>$r->duration,
                "user_id" => Auth::id(),
                "room_id" => $room->id,
                "created_at" => now(),
                "updated_at" => now(),

            ]);

           
        return redirect()->route('room.show', $room->id);
        // foreach ($r->choices as $choix) {
        //     print_r($choix);
        // }
       
   
}
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function get_all_topics(Room $room)
    {
       
        return $room->topics;
    }
   
}
