<?php
// app/Models/ProjectRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectRequest extends Model
{
    protected $table    = 'requests';
    protected $fillable = ['client_id','title','description','budget','deadline','status'];
    protected $casts    = ['deadline' => 'date', 'budget' => 'decimal:2'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
