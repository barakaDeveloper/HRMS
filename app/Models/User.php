<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Add these methods for better role handling
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('Super Admin');
    }

    public function isHRManager(): bool
    {
        return $this->hasRole('HR Manager');
    }

    public function isManager(): bool
    {
        return $this->hasRole('Manager');
    }

    public function isEmployee(): bool
    {
        return $this->hasRole('Employee');
    }
}