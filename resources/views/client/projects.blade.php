@extends('layouts.app')
@section('title','My Projects')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;" class="fade-up">
  <h2 style="font-family:var(--font-head);font-size:18px;font-weight:700;margin:0;">My Projects ({{ $projects->count() }})</h2>
  <a href="{{ route('client.request.create') }}" class="btn-primary btn-sm"><i class="bi bi-send"></i> New Request</a>
</div>

@if($projects->isEmpty())
  <div class="empty-state fade-up"><i class="bi bi-folder2-open"></i><p>No projects yet. <a href="{{ route('client.request.create') }}">Submit a request</a>.</p></div>
@else
<div class="panel fade-up">
  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Project</th><th>Status</th><th>Progress</th><th>Tasks</th><th>Deadline</th></tr></thead>
      <tbody>
        @foreach($projects as $p)
        @php
          $done  = $p->tasks->where('status','done')->count();
          $total = $p->tasks->count();
          $pct   = $total > 0 ? round(($done/$total)*100) : 0;
        @endphp
        <tr>
          <td>
            <div class="td-name">{{ $p->title }}</div>
            @if($p->description)
              <div style="font-size:11.5px;color:var(--text-muted);margin-top:2px;">{{ Str::limit($p->description,70) }}</div>
            @endif
          </td>
          <td><span class="status-badge {{ $p->statusBadgeClass() }}"><span class="status-dot"></span>{{ $p->statusLabel() }}</span></td>
          <td style="min-width:140px;">
            <div class="pb-wrap"><div class="pb-fill" data-w="{{ $pct }}%" style="width:0"></div></div>
            <div class="pb-pct">{{ $pct }}%</div>
          </td>
          <td style="font-size:13px;">{{ $done }}/{{ $total }} done</td>
          <td style="font-size:12.5px;color:var(--text-muted);">{{ $p->deadline ? $p->deadline->format('M d, Y') : '—' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif
@endsection
