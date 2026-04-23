<?php
// app/Http/Controllers/Admin/RequestController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectRequest;

class RequestController extends Controller
{
    public function index()
    {
        $pending  = ProjectRequest::with('client')->where('status','pending') ->latest()->get();
        $approved = ProjectRequest::with('client')->where('status','approved')->latest()->get();
        $rejected = ProjectRequest::with('client')->where('status','rejected')->latest()->get();

        return view('admin.requests.index', compact('pending','approved','rejected'));
    }

    public function approve(ProjectRequest $request)
    {
        $request->update(['status' => 'approved']);

        // Auto-create project from request
        Project::create([
            'client_id'   => $request->client_id,
            'title'       => $request->title,
            'description' => $request->description,
            'budget'      => $request->budget,
            'deadline'    => $request->deadline,
            'status'      => 'not_started',
        ]);

        return redirect()->route('admin.requests.index')
            ->with('success', 'Request approved! Project created automatically.');
    }

    public function reject(ProjectRequest $request)
    {
        $request->update(['status' => 'rejected']);
        return redirect()->route('admin.requests.index')
            ->with('success', 'Request rejected.');
    }
}
