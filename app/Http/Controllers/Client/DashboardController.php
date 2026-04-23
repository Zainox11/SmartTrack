<?php
// app/Http/Controllers/Client/DashboardController.php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user     = Auth::user();
        $projects = $user->projects()->with('tasks')->latest()->get();

        $stats = [
            'total'    => $projects->count(),
            'active'   => $projects->where('status','in_progress')->count(),
            'done'     => $projects->where('status','completed')->count(),
            'total_tasks' => $projects->sum(fn($p) => $p->tasks->count()),
            'done_tasks'  => $projects->sum(fn($p) => $p->tasks->where('status','done')->count()),
        ];

        $stats['done_pct'] = $stats['total_tasks'] > 0
            ? round(($stats['done_tasks'] / $stats['total_tasks']) * 100)
            : 0;

        $upcoming = $projects
            ->filter(fn($p) => $p->deadline && $p->status !== 'completed')
            ->sortBy('deadline')
            ->take(3);

        $recentTasks = Task::whereIn('project_id', $projects->pluck('id'))
            ->with('project')
            ->latest()
            ->take(6)
            ->get();

        return view('client.dashboard', compact('user','projects','stats','upcoming','recentTasks'));
    }
}
