<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class RoomController extends Controller
{

   public function store(Request $r){
     $data = $r->validate([
      "room_name" => "required|max:255",
      "room_desc"=> "required",
      "member_type" => "required",
      "member_limit" => "required|integer",
      "visibility" => "required",
      "vote_method" => "required"
      ]);



  if($data){
    DB::table('rooms')->insert([
            'name' => $r->room_name,
            'description' => $r->room_desc,
            'user_id' => Auth::id(),
            "member_limit" => $r->member_limit,
            "visibility" =>  $r->visibility,
            "vote_method" =>  $r->vote_method,
            'created_at' => now(),
            'updated_at' => now()
        ]);

           return redirect('/roomcreate')->with('success', 'Registration successful!');

  }
  return ;
   }



}
