<?php
// app/Http/Controllers/Admin/ProjectController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // List all projects
    public function index(Request $request)
    {
        $query = Project::with(['client', 'tasks']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $projects = $query->latest()->get();
        $clients  = User::where('role', 'client')->get();

        $stats = [
            'total'       => Project::count(),
            'in_progress' => Project::where('status','in_progress')->count(),
            'completed'   => Project::where('status','completed')->count(),
            'on_hold'     => Project::where('status','on_hold')->count(),
        ];

        return view('admin.projects.index', compact('projects', 'clients', 'stats'));
    }

    // Show create form
    public function create()
    {
        $clients = User::where('role', 'client')->get();
        return view('admin.projects.create', compact('clients'));
    }

    // Store new project
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'   => 'required|exists:users,id',
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'budget'      => 'nullable|numeric|min:0',
            'deadline'    => 'nullable|date|after:today',
            'status'      => 'required|in:not_started,in_progress,on_hold,completed',
        ]);

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
    }

    // Show edit form
    public function edit(Project $project)
    {
        $clients = User::where('role', 'client')->get();
        $tasks   = $project->tasks()->latest()->get();
        return view('admin.projects.edit', compact('project', 'clients', 'tasks'));
    }

    // Update project
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'client_id'   => 'required|exists:users,id',
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'budget'      => 'nullable|numeric|min:0',
            'deadline'    => 'nullable|date',
            'status'      => 'required|in:not_started,in_progress,on_hold,completed',
        ]);

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully!');
    }

    // Delete project (tasks deleted by cascade)
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted.');
    }
}
