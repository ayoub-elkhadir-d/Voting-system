<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;

class choix extends Model
{
    protected $fillable = ['name', 'topic_id', 'room_id'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function votes()
    {
        return $this->hasMany(\App\Models\Vote::class);
    }
}
