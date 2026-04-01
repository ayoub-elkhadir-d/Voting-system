<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;

class choix extends Model
{
    public function topic()
    {
        return $this->belongsTo(Topic::class);

    }
}
