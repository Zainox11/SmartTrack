<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'company'];

    protected $hidden = ['password', 'remember_token'];

    // ── Relationships ────────────────────────────────
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function projectRequests(): HasMany
    {
        return $this->hasMany(ProjectRequest::class, 'client_id');
    }

    // ── Helpers ──────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function initials(): string
    {
        $parts = explode(' ', $this->name);
        $i     = strtoupper(substr($parts[0], 0, 1));
        $i    .= isset($parts[1]) ? strtoupper(substr($parts[1], 0, 1)) : '';
        return $i;
    }
}
