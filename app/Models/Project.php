<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'tech_stack',
        'status',
        'start_date',
        'end_date',
        'supervisor_id',
        'created_by',
        'is_public',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_public' => 'boolean',
    ];

    // Relationships
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class)->orderBy('order');
    }

    // Helper methods
    public function getProgressAttribute()
    {
        $total = $this->milestones->count();
        if ($total === 0) return 0;

        $completed = $this->milestones->filter(function ($milestone) {
            return $milestone->submissions()
                ->where('status', 'approved')
                ->exists();
        })->count();

        return round(($completed / $total) * 100);
    }

    public function isLeader($userId)
    {
        $member = $this->members()->where('user_id', $userId)->first();
        return $member && $member->pivot->role === 'leader';
    }

    public function isMember($userId)
    {
        return $this->members()->where('user_id', $userId)->exists();
    }
}