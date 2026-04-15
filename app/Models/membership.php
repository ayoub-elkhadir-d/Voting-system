<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Room;
class membership extends Model
{
    public function room()
{
    return $this->belongsTo(Room::class);
}

public function user()
{
    return $this->belongsTo(User::class); 
}
}
