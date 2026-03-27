<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupervisorProfile extends Model
{
    protected $fillable = [
        'user_id', 'department', 'office_room', 'max_students'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}