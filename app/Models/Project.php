<?php
// app/Models/Project.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = ['client_id','title','description','budget','deadline','status'];

    protected $casts = ['deadline' => 'date', 'budget' => 'decimal:2'];

    // ── Relationships ────────────────────────────────
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // ── Helpers ──────────────────────────────────────
    public function progressPercent(): int
    {
        $total = $this->tasks()->count();
        if ($total === 0) return 0;
        $done = $this->tasks()->where('status', 'done')->count();
        return (int) round(($done / $total) * 100);
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'in_progress' => 'in-progress',
            'completed'   => 'completed',
            'on_hold'     => 'on-hold',
            default       => 'not-started',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'in_progress' => 'In Progress',
            'completed'   => 'Completed',
            'on_hold'     => 'On Hold',
            default       => 'Not Started',
        };
    }
}
