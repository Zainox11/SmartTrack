<?php
// app/Models/Task.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = ['project_id','title','description','priority','status','due_date'];

    protected $casts = ['due_date' => 'date'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'in_progress' => 'in-progress',
            'done'        => 'completed',
            default       => 'todo',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'in_progress' => 'In Progress',
            'done'        => 'Done',
            default       => 'To Do',
        };
    }
}
