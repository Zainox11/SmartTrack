@extends('layouts.app')
@section('title','Clients')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;" class="fade-up">
  <h2 style="font-family:var(--font-head);font-size:18px;font-weight:700;margin:0;">Clients ({{ $clients->count() }})</h2>
  <a href="{{ route('admin.clients.create') }}" class="btn-primary btn-sm"><i class="bi bi-person-plus"></i> Add Client</a>
</div>

@if($clients->isEmpty())
  <div class="empty-state"><i class="bi bi-people"></i><p>No clients yet. <a href="{{ route('admin.clients.create') }}">Add one</a>.</p></div>
@else
<div class="panel fade-up">
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Company</th><th>Projects</th><th>Joined</th><th style="text-align:center;">Actions</th></tr>
      </thead>
      <tbody>
        @foreach($clients as $client)
        @php
          $colors=['linear-gradient(135deg,#00C9A7,#007B8A)','linear-gradient(135deg,#3B82F6,#1D4ED8)','linear-gradient(135deg,#7C3AED,#5B21B6)','linear-gradient(135deg,#F59E0B,#D97706)','linear-gradient(135deg,#10B981,#059669)'];
          $clr=$colors[$client->id % count($colors)];
        @endphp
        <tr>
          <td style="color:var(--text-muted);font-size:12px;">{{ $client->id }}</td>
          <td>
            <div style="display:flex;align-items:center;gap:9px;">
              <div style="width:34px;height:34px;border-radius:50%;background:{{ $clr }};display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0;">
                {{ $client->initials() }}
              </div>
              <div class="td-name">{{ $client->name }}</div>
            </div>
          </td>
          <td>{{ $client->email }}</td>
          <td>{{ $client->phone ?: '—' }}</td>
          <td>{{ $client->company ?: '—' }}</td>
          <td>
            <a href="{{ route('admin.projects.index', ['client_id'=>$client->id]) }}"
               style="font-weight:600;color:var(--accent);text-decoration:none;">
              {{ $client->projects_count }} project{{ $client->projects_count !== 1 ? 's':'' }}
            </a>
          </td>
          <td style="font-size:12.5px;color:var(--text-muted);">{{ $client->created_at->format('M d, Y') }}</td>
          <td>
            <div class="actions-cell" style="justify-content:center;">
              <a href="{{ route('admin.clients.edit',$client) }}" class="act-btn edit"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.clients.destroy',$client) }}" style="display:inline;"
                    onsubmit="return confirm('Delete client \'{{ addslashes($client->name) }}\'?')">
                @csrf @method('DELETE')
                <button type="submit" class="act-btn delete"><i class="bi bi-trash3"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="table-footer"><span class="tf-info">{{ $clients->count() }} client(s)</span></div>
</div>
@endif
@endsection
