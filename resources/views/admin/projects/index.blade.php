@extends('layouts.app')
@section('title','Projects')

@section('content')


{{-- Mini Stats --}}
<div class="row g-3 mb-3 fade-up">
  <div class="col-sm-3"><div class="sm-card"><div class="sm-icon" style="background:rgba(0,201,167,0.12);color:var(--accent);">📁</div><div><div class="sm-val" data-count="{{ $stats['total'] }}">0</div><div class="sm-lbl">Total</div></div></div></div>
  <div class="col-sm-3"><div class="sm-card"><div class="sm-icon" style="background:rgba(59,130,246,0.12);color:#3B82F6;">🔄</div><div><div class="sm-val" data-count="{{ $stats['in_progress'] }}">0</div><div class="sm-lbl">In Progress</div></div></div></div>
  <div class="col-sm-3"><div class="sm-card"><div class="sm-icon" style="background:rgba(16,185,129,0.12);color:#10B981;">✅</div><div><div class="sm-val" data-count="{{ $stats['completed'] }}">0</div><div class="sm-lbl">Completed</div></div></div></div>
  <div class="col-sm-3"><div class="sm-card"><div class="sm-icon" style="background:rgba(245,158,11,0.12);color:#F59E0B;">⏸️</div><div><div class="sm-val" data-count="{{ $stats['on_hold'] }}">0</div><div class="sm-lbl">On Hold</div></div></div></div>
</div>

<div class="panel fade-up">
  <div class="panel-header">
    <span class="panel-title">All Projects</span>
    <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
      <form method="GET" style="display:flex;gap:6px;">
        <select name="status" class="form-control-st" style="width:auto;padding:6px 10px;font-size:12.5px;" onchange="this.form.submit()">
          <option value="">All Statuses</option>
          @foreach(['in_progress'=>'In Progress','completed'=>'Completed','on_hold'=>'On Hold','not_started'=>'Not Started'] as $v=>$l)
          <option value="{{ $v }}" {{ request('status')===$v?'selected':'' }}>{{ $l }}</option>
          @endforeach
        </select>
      </form>
      <a href="{{ route('admin.projects.create') }}" class="btn-primary btn-sm"><i class="bi bi-plus-lg"></i> New Project</a>
    </div>
  </div>

  @if($projects->isEmpty())
    <div class="empty-state"><i class="bi bi-folder2-open"></i><p>No projects. <a href="{{ route('admin.projects.create') }}">Create one</a></p></div>
  @else
  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Project</th><th>Client</th><th>Status</th><th>Progress</th><th>Deadline</th><th style="text-align:center;">Actions</th></tr></thead>
      <tbody>
      @foreach($projects as $project)
      <tr>
        <td><div class="td-name">{{ $project->title }}</div><div style="font-size:11.5px;color:var(--text-muted);">{{ $project->tasks->count() }} task(s)</div></td>
        <td>{{ $project->client->name }}</td>
        <td><span class="status-badge {{ $project->statusBadgeClass() }}"><span class="status-dot"></span>{{ $project->statusLabel() }}</span></td>
        <td style="min-width:120px;">
          @php $pct = $project->progressPercent() @endphp
          <div class="pb-wrap"><div class="pb-fill" data-w="{{ $pct }}%" style="width:0"></div></div>
          <div class="pb-pct">{{ $pct }}%</div>
        </td>
        <td style="font-size:12.5px;color:var(--text-muted);">{{ $project->deadline?->format('M d, Y') ?? '—' }}</td>
        <td><div class="actions-cell" style="justify-content:center;">
          <a href="{{ route('admin.projects.edit',$project) }}" class="act-btn edit" title="Edit"><i class="bi bi-pencil"></i></a>
          <form method="POST" action="{{ route('admin.projects.destroy',$project) }}" style="display:inline;"
                onsubmit="return confirm('Delete {{ $project->title }} and all its tasks?')">
            @csrf @method('DELETE')
            <button type="submit" class="act-btn delete" title="Delete"><i class="bi bi-trash3"></i></button>
          </form>
        </div></td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <div class="table-footer"><span class="tf-info">{{ $projects->count() }} project(s)</span></div>
  @endif
</div>

@endsection