<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user       = Auth::user();
        $projectIds = $user->projects()->pluck('id');
        $tasks      = Task::with('project')->whereIn('project_id',$projectIds)->latest()->get();
        $stats = ['todo'=>$tasks->where('status','todo')->count(),'inprog'=>$tasks->where('status','in_progress')->count(),'done'=>$tasks->where('status','done')->count()];
        return view('client.tasks', compact('tasks','stats'));
    }
}
