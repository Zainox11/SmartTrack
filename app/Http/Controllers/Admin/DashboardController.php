<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\ProjectRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_projects'    => Project::count(),
            'active_projects'   => Project::where('status', 'in_progress')->count(),
            'total_clients'     => User::where('role', 'client')->count(),
            'pending_tasks'     => Task::where('status', 'todo')->count(),
            'done_tasks'        => Task::where('status', 'done')->count(),
            'total_tasks'       => Task::count(),
            'pending_requests'  => ProjectRequest::where('status', 'pending')->count(),
        ];

        $stats['done_pct'] = $stats['total_tasks'] > 0
            ? round(($stats['done_tasks'] / $stats['total_tasks']) * 100)
            : 0;

        // Recent 5 projects with client and task counts
        $recentProjects = Project::with(['client', 'tasks'])
            ->latest()
            ->take(5)
            ->get();

        // Pending tasks for quick view
        $pendingTasks = Task::with('project')
            ->where('status', 'todo')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProjects', 'pendingTasks'));
    }
}
