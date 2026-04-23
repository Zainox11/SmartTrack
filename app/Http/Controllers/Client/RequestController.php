<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\ProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function create()
    {
        $myRequests = Auth::user()->projectRequests()->latest()->get();
        return view('client.request', compact('myRequests'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'required|string',
            'budget'      => 'nullable|numeric|min:0',
            'deadline'    => 'nullable|date|after:today',
        ]);
        $data['client_id'] = Auth::id();
        $data['status']    = 'pending';
        ProjectRequest::create($data);
        return redirect()->route('client.request.create')->with('success','Request submitted! Admin will review it shortly.');
    }
}
