<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'type',
        'deadline',
        'order',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function latestSubmission()
    {
        return $this->hasOne(Submission::class)->latest();
    }

    public function getApprovedSubmissionAttribute()
    {
        return $this->submissions()->where('status', 'approved')->first();
    }

    public function isOverdue()
    {
        return $this->deadline->isPast() && !$this->approvedSubmission;
    }
}