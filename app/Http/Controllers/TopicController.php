<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Topic;
use App\Models\choix;
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
       $topic = Topic::create([
            "name" => $data["topic_name"],
            "duration" => $data["duration"],
            "vote_methode" =>$r->vote_method,
            "user_id" => Auth::id(),
            "room_id" => $room->id,
            "created_at" => now(),
            "updated_at" => now(),
          ]);



        foreach ($r->choices as $choix) {
            DB::table("choixes")->insert([
                "name" => $choix,
                "room_id"=>$room->id,
                "topic_id" =>  $topic->id,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
    return redirect(session('return_url',route('room.show', $room->id)));
 
        
   }
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
    public function update(Request $re,Room $room, string $id, string $room_id)
    {
        $re->validate([
            'topic_name' => 'required|string|max:255',
            'duration'   => 'required',
            'choices'    => 'required|array|min:1',
        ]);

        $topic = Topic::findOrFail($id);
        $topic->update([
            'name'         => $re->topic_name,
            'duration'     => $re->duration,
            'vote_methode' => $re->vote_method,
        ]);

        
        choix::where('topic_id', $id)->delete();
        foreach ($re->choices as $choice) {
            choix::create([
                'name'     => $choice,
                'topic_id' => $id,
                'room_id'  => $room_id,
            ]);
        }

        return redirect()->back()->with('success', 'Topic updated successfully!');
    }

    public function get_all_topics(Room $room)
    {
     
      return $room->topics;
    }

  public function restart($roomId, $topicId)
{
    $topic = Topic::where('room_id', $roomId)
        ->where('id', $topicId)
        ->first();

    if (!$topic) {
        return back();
    }

   
    $topic->status = 'pending';
    $topic->started_at = null;
    $topic->save();

  


    return back();
}
   
}
