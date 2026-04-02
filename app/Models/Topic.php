<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Room;
use App\Models\choix;

class Topic extends Model
{

protected $fillable = ['name','duration','room_id','user_id','vote_methode'];

     public function user()
    {
        return $this->belongsTo(User::class);

    }
   public function room()
    {
        return $this->belongsTo(Room::class);

    }

public function choix(){
    return $this->hasmany(choix::class);
}

}
