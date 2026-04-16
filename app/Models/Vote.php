<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'topic_id', 'choix_id', 'room_id'];
}
