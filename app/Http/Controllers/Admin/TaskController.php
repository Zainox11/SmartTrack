<?php
// app/Http/Controllers/Admin/TaskController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('project');

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $tasks = $query->latest()->get();

        $todo    = $tasks->where('status', 'todo');
        $inProg  = $tasks->where('status', 'in_progress');
        $done    = $tasks->where('status', 'done');
        $projects= Project::orderBy('title')->get();

        return view('admin.tasks.index', compact('tasks','todo','inProg','done','projects'));
    }

    public function create(Request $request)
    {
        $projects   = Project::orderBy('title')->get();
        $preProject = $request->project_id;
        return view('admin.tasks.create', compact('projects', 'preProject'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'status'      => 'required|in:todo,in_progress,done',
            'due_date'    => 'nullable|date',
        ]);

        Task::create($data);

        $redirect = $request->project_id
            ? route('admin.tasks.index', ['project_id' => $request->project_id])
            : route('admin.tasks.index');

        return redirect($redirect)->with('success', 'Task created!');
    }

    public function edit(Task $task)
    {
        $projects = Project::orderBy('title')->get();
        return view('admin.tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'status'      => 'required|in:todo,in_progress,done',
            'due_date'    => 'nullable|date',
        ]);

        $task->update($data);

        return redirect()->route('admin.tasks.index', ['project_id' => $task->project_id])
            ->with('success', 'Task updated!');
    }

    public function destroy(Task $task)
    {
        $projectId = $task->project_id;
        $task->delete();
        return redirect()->route('admin.tasks.index', ['project_id' => $projectId])
            ->with('success', 'Task deleted.');
    }

    // AJAX: update status only
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate(['status' => 'required|in:todo,in_progress,done']);
        $task->update(['status' => $request->status]);
        return response()->json(['success' => true, 'status' => $task->status]);
    }
}
