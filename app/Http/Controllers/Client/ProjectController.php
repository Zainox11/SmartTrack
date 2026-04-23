<?php
// app/Http/Controllers/Client/ProjectController.php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->projects()->with('tasks')->latest()->get();
        return view('client.projects', compact('projects'));
    }
}
