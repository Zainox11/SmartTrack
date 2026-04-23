@extends('layouts.app')
@section('title','My Dashboard')

@section('content')

<div style="background:var(--bg-card);border:1.5px solid var(--border);border-radius:14px;padding:18px 22px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:22px;" class="fade-up">
  <div style="display:flex;align-items:center;gap:14px;">
    <div style="width:44px;height:44px;background:linear-gradient(135deg,#34D399,#059669);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:800;color:#fff;">{{ substr($user->name,0,1) }}</div>
    <div>
      <div style="font-family:var(--font-head);font-size:18px;font-weight:700;">Welcome back, {{ explode(' ',$user->name)[0] }}!</div>
      <div style="font-size:13px;color:var(--text-secondary);margin-top:2px;">{{ $stats['active'] }} active project(s) &mdash; {{ $stats['done_pct'] }}% tasks done</div>
    </div>
  </div>
  <a href="{{ route('client.request.create') }}" class="btn-primary"><i class="bi bi-send"></i> New Request</a>
</div>

<div class="row g-3 mb-4">
  <div class="col-lg-4 col-md-6">
    <div class="stat-card teal fade-up d1">
      <div class="stat-card-label">Total Projects</div>
      <div class="stat-card-value" data-count="{{ $stats['total'] }}">0</div>
      <div class="stat-card-sub">{{ $stats['active'] }} active &mdash; {{ $stats['done'] }} done</div>
      <div class="stat-card-visual">
        <svg data-spark="1,1,2,2,3,{{ max(1,$stats['total']) }}" data-spark-color="rgba(255,255,255,0.85)" data-spark-fill="rgba(255,255,255,0.15)"></svg>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="stat-card navy fade-up d2">
      <div class="stat-card-label">Task Progress</div>
      <div class="stat-card-value">{{ $stats['done_pct'] }}<span style="font-size:22px;opacity:.7;">%</span></div>
      <div class="stat-card-sub">{{ $stats['done_tasks'] }}/{{ $stats['total_tasks'] }} tasks done</div>
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
      <div class="stat-card-label">Upcoming Deadlines</div>
      <div class="stat-card-value" data-count="{{ $upcoming->count() }}">0</div>
      <div class="stat-card-sub">projects due soon</div>
      @if($upcoming->isNotEmpty())
      <div class="deadline-list">
        @foreach($upcoming->take(2) as $p)
        <div class="deadline-item">
          <span class="dl-name">{{ $p->title }}</span>
          <span class="dl-date">{{ $p->deadline->format('M d') }}</span>
        </div>
        @endforeach
      </div>
      @endif
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-xl-8">
    <div class="panel fade-up d3">
      <div class="panel-header">
        <span class="panel-title">My Projects</span>
        <a href="{{ route('client.projects') }}" class="btn-ghost btn-sm">View All</a>
      </div>
      @if($projects->isEmpty())
        <div class="empty-state"><i class="bi bi-folder2-open"></i><p>No projects yet. <a href="{{ route('client.request.create') }}">Submit a request</a>.</p></div>
      @else
      <div class="table-wrap">
        <table class="data-table">
          <thead><tr><th>Project</th><th>Status</th><th>Progress</th><th>Deadline</th></tr></thead>
          <tbody>
            @foreach($projects->take(5) as $p)
            @php $pct=$p->progressPercent(); @endphp
            <tr>
              <td class="td-name">{{ $p->title }}</td>
              <td><span class="status-badge {{ $p->statusBadgeClass() }}"><span class="status-dot"></span>{{ $p->statusLabel() }}</span></td>
              <td style="min-width:130px;">
                <div class="pb-wrap"><div class="pb-fill" data-w="{{ $pct }}%" style="width:0"></div></div>
                <div class="pb-pct">{{ $pct }}% ({{ $p->tasks->where('status','done')->count() }}/{{ $p->tasks->count() }})</div>
              </td>
              <td style="font-size:12.5px;color:var(--text-muted);">{{ $p->deadline ? $p->deadline->format('M d, Y') : '—' }}</td>
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
        <span class="panel-title">My Tasks</span>
        <a href="{{ route('client.tasks') }}" class="btn-ghost btn-sm">View All</a>
      </div>
      <div style="padding:0 16px;">
        @forelse($recentTasks as $task)
        <div class="task-qv-item">
          <div style="flex:1;overflow:hidden;">
            <div class="task-qv-title">{{ $task->title }}</div>
            <div style="font-size:10.5px;color:var(--text-muted);">{{ $task->project->title ?? '' }}</div>
          </div>
          <span class="status-badge {{ $task->statusBadgeClass() }}" style="font-size:10.5px;padding:2px 7px;"><span class="status-dot"></span>{{ $task->statusLabel() }}</span>
        </div>
        @empty
        <div class="empty-state" style="padding:24px 0;"><i class="bi bi-list-task"></i><p>No tasks assigned.</p></div>
        @endforelse
      </div>
    </div>
  </div>
</div>

@endsection
