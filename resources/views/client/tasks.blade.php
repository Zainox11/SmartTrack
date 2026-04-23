@extends('layouts.app')
@section('title','My Tasks')

@section('content')

<div class="row g-3 mb-3 fade-up">
  <div class="col-sm-4"><div class="sm-card"><div class="sm-icon" style="background:#F1F5F9;color:#64748B;">📋</div><div><div class="sm-val" data-count="{{ $stats['todo'] }}">0</div><div class="sm-lbl">To Do</div></div></div></div>
  <div class="col-sm-4"><div class="sm-card"><div class="sm-icon" style="background:rgba(0,201,167,0.12);color:var(--accent);">🔄</div><div><div class="sm-val" data-count="{{ $stats['inprog'] }}">0</div><div class="sm-lbl">In Progress</div></div></div></div>
  <div class="col-sm-4"><div class="sm-card"><div class="sm-icon" style="background:rgba(16,185,129,0.12);color:#10B981;">✅</div><div><div class="sm-val" data-count="{{ $stats['done'] }}">0</div><div class="sm-lbl">Done</div></div></div></div>
</div>

<div class="panel fade-up">
  <div class="panel-header"><span class="panel-title">All My Tasks</span></div>
  @if($tasks->isEmpty())
    <div class="empty-state"><i class="bi bi-list-task"></i><p>No tasks assigned yet.</p></div>
  @else
  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Task</th><th>Project</th><th>Priority</th><th>Status</th><th>Due Date</th></tr></thead>
      <tbody>
        @foreach($tasks as $task)
        <tr>
          <td class="td-name">{{ $task->title }}</td>
          <td style="font-size:13px;">{{ $task->project->title ?? '—' }}</td>
          <td><span class="priority-tag {{ $task->priority }}">{{ ucfirst($task->priority) }}</span></td>
          <td><span class="status-badge {{ $task->statusBadgeClass() }}"><span class="status-dot"></span>{{ $task->statusLabel() }}</span></td>
          <td style="font-size:12.5px;color:var(--text-muted);">{{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>
@endsection
