<?php
// app/Http/Controllers/Admin/ClientController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'client')
            ->withCount('projects')
            ->latest()
            ->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', Password::min(6)],
            'phone'    => 'nullable|string|max:20',
            'company'  => 'nullable|string|max:100',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'client',
            'phone'    => $data['phone']   ?? null,
            'company'  => $data['company'] ?? null,
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client added successfully!');
    }

    public function edit(User $client)
    {
        abort_if($client->role !== 'client', 404);
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, User $client)
    {
        abort_if($client->role !== 'client', 404);

        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'phone'        => 'nullable|string|max:20',
            'company'      => 'nullable|string|max:100',
            'new_password' => ['nullable', Password::min(6)],
        ]);

        $updates = [
            'name'    => $data['name'],
            'phone'   => $data['phone']   ?? null,
            'company' => $data['company'] ?? null,
        ];

        if (!empty($data['new_password'])) {
            $updates['password'] = Hash::make($data['new_password']);
        }

        $client->update($updates);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client updated!');
    }

    public function destroy(User $client)
    {
        abort_if($client->role !== 'client', 404);
        $client->delete();
        return redirect()->route('admin.clients.index')
            ->with('success', 'Client removed.');
    }
}
