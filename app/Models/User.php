<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship: Student profile
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    // Relationship: Supervisor profile
    public function supervisorProfile()
    {
        return $this->hasOne(SupervisorProfile::class);
    }

    // Role check methods
    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isSupervisor()
    {
        return $this->role === 'supervisor';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}