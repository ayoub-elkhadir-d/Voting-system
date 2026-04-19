<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Room;
class membership extends Model
{
     protected $fillable = [
        'room_id',
        'user_id',
        'username',
        'role',
        'status',
    ];
    
    public function room()
{
    return $this->belongsTo(Room::class);
}

public function user()
{
    return $this->belongsTo(User::class); 
}
}
