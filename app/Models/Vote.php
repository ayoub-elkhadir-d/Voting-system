<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'topic_id', 'choix_id', 'room_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function choix()
    {
        return $this->belongsTo(choix::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
