@extends('layouts.app')
@section('title','Dashboard')

@section('content')

<div style="background:var(--bg-card);border:1.5px solid var(--border);border-radius:14px;padding:18px 22px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:22px;" class="fade-up">
  <div style="display:flex;align-items:center;gap:14px;">
    <div style="width:44px;height:44px;background:linear-gradient(135deg,#E0F2FE,#BAE6FD);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;">👤</div>
    <div>
      <div style="font-family:var(--font-head);font-size:18px;font-weight:700;">Welcome back, {{ explode(' ',auth()->user()->name)[0] }}!</div>
      <div style="font-size:13px;color:var(--text-secondary);margin-top:2px;">{{ $stats['pending_requests'] }} pending request(s) &mdash; {{ $stats['pending_tasks'] }} tasks waiting</div>
    </div>
  </div>
  <a href="{{ route('admin.projects.create') }}" class="btn-primary"><i class="bi bi-folder-plus"></i> New Project</a>
</div>

<div class="row g-3 mb-4">
  <div class="col-lg-4 col-md-6">
    <div class="stat-card teal fade-up d1">
      <div class="stat-card-label">Active Projects</div>
      <div class="stat-card-value" data-count="{{ $stats['active_projects'] }}">0</div>
      <div class="stat-card-sub">{{ $stats['total_projects'] }} total</div>
      <div class="stat-card-visual">
        <svg data-spark="2,4,3,6,5,{{ max(1,$stats['total_projects']) }}" data-spark-color="rgba(255,255,255,0.85)" data-spark-fill="rgba(255,255,255,0.15)"></svg>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="stat-card navy fade-up d2">
      <div class="stat-card-label">Pending Tasks</div>
      <div class="stat-card-value" data-count="{{ $stats['pending_tasks'] }}">0</div>
      <div class="stat-card-sub">{{ $stats['done_pct'] }}% completed</div>
      <div class="stat-card-visual">
        <div class="donut-wrap">
          <svg data-donut="{{ $stats['done_pct'] }}" data-donut-color="#00C9A7" data-donut-track="rgba(255,255,255,0.12)"></svg>
          <div class="donut-label-center">{{ $stats['done_pct'] }}%<small>done</small></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="stat-card purple fade-up d3">
      <div class="stat-card-label">Active Clients</div>
      <div class="stat-card-value" data-count="{{ $stats['total_clients'] }}">0</div>
      <div class="stat-card-sub">{{ $stats['pending_requests'] }} pending request(s)</div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-xl-8">
    <div class="panel fade-up d3">
      <div class="panel-header">
        <span class="panel-title">Recent Projects</span>
        <div style="display:flex;gap:8px;">
          <a href="{{ route('admin.projects.index') }}" class="btn-ghost btn-sm">View All</a>
          <a href="{{ route('admin.projects.create') }}" class="btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add</a>
        </div>
      </div>
      @if($recentProjects->isEmpty())
        <div class="empty-state"><i class="bi bi-folder2-open"></i><p>No projects yet. <a href="{{ route('admin.projects.create') }}">Create one</a></p></div>
      @else
      <div class="table-wrap">
        <table class="data-table">
          <thead><tr><th>Project</th><th>Client</th><th>Status</th><th>Progress</th><th>Deadline</th><th style="text-align:center;">Actions</th></tr></thead>
          <tbody>
            @foreach($recentProjects as $proj)
            @php $pct = $proj->progressPercent(); @endphp
            <tr>
              <td><div class="td-name">{{ $proj->title }}</div><div style="font-size:11.5px;color:var(--text-muted);">{{ $proj->tasks->count() }} task(s)</div></td>
              <td style="font-size:13px;">{{ $proj->client->name ?? '—' }}</td>
              <td><span class="status-badge {{ $proj->statusBadgeClass() }}"><span class="status-dot"></span>{{ $proj->statusLabel() }}</span></td>
              <td style="min-width:110px;">
                <div class="pb-wrap"><div class="pb-fill" data-w="{{ $pct }}%" style="width:0"></div></div>
                <div class="pb-pct">{{ $pct }}%</div>
              </td>
              <td style="font-size:12.5px;color:var(--text-muted);">{{ $proj->deadline ? $proj->deadline->format('M d, Y') : '—' }}</td>
              <td>
                <div class="actions-cell" style="justify-content:center;">
                  <a href="{{ route('admin.projects.edit',$proj) }}" class="act-btn edit"><i class="bi bi-pencil"></i></a>
                  <form method="POST" action="{{ route('admin.projects.destroy',$proj) }}" style="display:inline;" onsubmit="return confirm('Delete this project?')">
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
      @endif
    </div>
  </div>

  <div class="col-xl-4">
    <div class="panel fade-up d4" style="height:100%;">
      <div class="panel-header">
        <span class="panel-title">Pending Tasks</span>
        <a href="{{ route('admin.tasks.create') }}" class="btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add</a>
      </div>
      <div style="padding:0 16px;">
        @forelse($pendingTasks as $task)
        <div class="task-qv-item">
          <div style="flex:1;overflow:hidden;">
            <div class="task-qv-title">{{ $task->title }}</div>
            <div style="font-size:10.5px;color:var(--text-muted);">{{ $task->project->title ?? '' }}</div>
          </div>
          <span class="priority-tag {{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
        </div>
        @empty
        <div class="empty-state" style="padding:24px 0;"><i class="bi bi-check-all"></i><p>All done!</p></div>
        @endforelse
      </div>
      <div style="padding:12px 16px;border-top:1px solid var(--border);text-align:center;">
        <a href="{{ route('admin.tasks.index') }}" class="btn-ghost btn-sm" style="width:100%;justify-content:center;">View All Tasks <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  </div>
</div>

@endsection
