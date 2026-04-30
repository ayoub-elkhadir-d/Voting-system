<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Topic;
use App\Models\membership;
class Room extends Model
{
    protected $fillable = ['name', 'code', 'description', 'user_id', 'member_limit', 'visibility', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);

    }
    public function topics() {
    
    return $this->hasMany(Topic::class);
    }
    public function memberships()
{
    return $this->hasMany(Membership::class);
}
}
