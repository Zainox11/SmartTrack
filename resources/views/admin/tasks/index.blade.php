@extends('layouts.app')
@section('title','Tasks')

@section('content')

{{-- Header --}}
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:20px;" class="fade-up">
  <div>
    <h2 style="font-family:var(--font-head);font-size:18px;font-weight:700;margin:0;">Tasks</h2>
    <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">{{ $tasks->count() }} total tasks</div>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
    <form method="GET" style="display:flex;gap:6px;">
      <select name="project_id" class="form-control-st" style="width:auto;padding:6px 10px;font-size:12.5px;" onchange="this.form.submit()">
        <option value="">All Projects</option>
        @foreach($projects as $p)
          <option value="{{ $p->id }}" {{ request('project_id') == $p->id ? 'selected' : '' }}>
            {{ $p->title }}
          </option>
        @endforeach
      </select>
    </form>
    <a href="{{ route('admin.tasks.create', request('project_id') ? ['project_id'=>request('project_id')] : []) }}"
       class="btn-primary btn-sm">
      <i class="bi bi-plus-lg"></i> Add Task
    </a>
  </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4 fade-up">
  <div class="col-sm-4">
    <div class="sm-card">
      <div class="sm-icon" style="background:#F1F5F9;color:#64748B;">📋</div>
      <div><div class="sm-val" data-count="{{ $todo->count() }}">0</div><div class="sm-lbl">To Do</div></div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="sm-card">
      <div class="sm-icon" style="background:rgba(0,201,167,0.12);color:var(--accent);">🔄</div>
      <div><div class="sm-val" data-count="{{ $inProg->count() }}">0</div><div class="sm-lbl">In Progress</div></div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="sm-card">
      <div class="sm-icon" style="background:rgba(16,185,129,0.12);color:#10B981;">✅</div>
      <div><div class="sm-val" data-count="{{ $done->count() }}">0</div><div class="sm-lbl">Done</div></div>
    </div>
  </div>
</div>

{{-- Kanban Board --}}
<div class="kanban-board fade-up">

  {{-- TO DO --}}
  <div class="kanban-col kanban-accent-todo">
    <div class="kanban-col-header">
      <div class="kanban-col-title">
        <span style="width:9px;height:9px;background:#94A3B8;border-radius:50%;display:inline-block;"></span>
        To Do
      </div>
      <span class="kanban-count" style="background:#F1F5F9;color:#64748B;">{{ $todo->count() }}</span>
    </div>
    <div class="kanban-col-body">
      @forelse($todo as $task)
        <div class="task-card" id="task-{{ $task->id }}">
          <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
            <div class="task-card-title">{{ $task->title }}</div>
            <select class="task-status-select" data-task-id="{{ $task->id }}"
                    style="border:1px solid var(--border);border-radius:6px;padding:2px 6px;font-size:11px;color:var(--text-secondary);cursor:pointer;background:var(--bg-main);">
              <option value="todo" selected>To Do</option>
              <option value="in_progress">In Progress</option>
              <option value="done">Done</option>
            </select>
          </div>
          <div class="task-card-proj"><i class="bi bi-folder2"></i>{{ $task->project->title ?? '—' }}</div>
          <div class="task-card-footer">
            <span class="priority-tag {{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
            <div style="display:flex;align-items:center;gap:6px;">
              @if($task->due_date)
                <span class="task-due"><i class="bi bi-calendar3"></i>{{ $task->due_date->format('M d') }}</span>
              @endif
              <a href="{{ route('admin.tasks.edit',$task) }}" class="act-btn edit" style="width:24px;height:24px;font-size:12px;"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.tasks.destroy',$task) }}" style="display:inline;"
                    onsubmit="return confirm('Delete this task?')">
                @csrf @method('DELETE')
                <button type="submit" class="act-btn delete" style="width:24px;height:24px;font-size:12px;"><i class="bi bi-trash3"></i></button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div style="text-align:center;padding:20px;color:var(--text-muted);font-size:12.5px;">No tasks here</div>
      @endforelse
    </div>
  </div>

  {{-- IN PROGRESS --}}
  <div class="kanban-col kanban-accent-prog">
    <div class="kanban-col-header">
      <div class="kanban-col-title">
        <span style="width:9px;height:9px;background:var(--accent);border-radius:50%;display:inline-block;"></span>
        In Progress
      </div>
      <span class="kanban-count" style="background:rgba(0,201,167,0.12);color:var(--accent);">{{ $inProg->count() }}</span>
    </div>
    <div class="kanban-col-body">
      @forelse($inProg as $task)
        <div class="task-card" style="border-left:3px solid var(--accent);" id="task-{{ $task->id }}">
          <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
            <div class="task-card-title">{{ $task->title }}</div>
            <select class="task-status-select" data-task-id="{{ $task->id }}"
                    style="border:1px solid var(--border);border-radius:6px;padding:2px 6px;font-size:11px;color:var(--text-secondary);cursor:pointer;background:var(--bg-main);">
              <option value="todo">To Do</option>
              <option value="in_progress" selected>In Progress</option>
              <option value="done">Done</option>
            </select>
          </div>
          <div class="task-card-proj"><i class="bi bi-folder2"></i>{{ $task->project->title ?? '—' }}</div>
          <div class="task-card-footer">
            <span class="priority-tag {{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
            <div style="display:flex;align-items:center;gap:6px;">
              @if($task->due_date)
                <span class="task-due"><i class="bi bi-calendar3"></i>{{ $task->due_date->format('M d') }}</span>
              @endif
              <a href="{{ route('admin.tasks.edit',$task) }}" class="act-btn edit" style="width:24px;height:24px;font-size:12px;"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.tasks.destroy',$task) }}" style="display:inline;"
                    onsubmit="return confirm('Delete this task?')">
                @csrf @method('DELETE')
                <button type="submit" class="act-btn delete" style="width:24px;height:24px;font-size:12px;"><i class="bi bi-trash3"></i></button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div style="text-align:center;padding:20px;color:var(--text-muted);font-size:12.5px;">No tasks here</div>
      @endforelse
    </div>
  </div>

  {{-- DONE --}}
  <div class="kanban-col kanban-accent-done">
    <div class="kanban-col-header">
      <div class="kanban-col-title">
        <span style="width:9px;height:9px;background:#10B981;border-radius:50%;display:inline-block;"></span>
        Done
      </div>
      <span class="kanban-count" style="background:rgba(16,185,129,0.12);color:#10B981;">{{ $done->count() }}</span>
    </div>
    <div class="kanban-col-body">
      @forelse($done as $task)
        <div class="task-card" style="opacity:0.75;" id="task-{{ $task->id }}">
          <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px;">
            <div class="task-card-title" style="text-decoration:line-through;color:var(--text-muted);">{{ $task->title }}</div>
            <select class="task-status-select" data-task-id="{{ $task->id }}"
                    style="border:1px solid var(--border);border-radius:6px;padding:2px 6px;font-size:11px;color:var(--text-secondary);cursor:pointer;background:var(--bg-main);">
              <option value="todo">To Do</option>
              <option value="in_progress">In Progress</option>
              <option value="done" selected>Done</option>
            </select>
          </div>
          <div class="task-card-proj"><i class="bi bi-folder2"></i>{{ $task->project->title ?? '—' }}</div>
          <div class="task-card-footer">
            <span class="status-badge completed" style="font-size:10.5px;"><span class="status-dot"></span>Done</span>
            <form method="POST" action="{{ route('admin.tasks.destroy',$task) }}" style="display:inline;"
                  onsubmit="return confirm('Delete this task?')">
              @csrf @method('DELETE')
              <button type="submit" class="act-btn delete" style="width:24px;height:24px;font-size:12px;"><i class="bi bi-trash3"></i></button>
            </form>
          </div>
        </div>
      @empty
        <div style="text-align:center;padding:20px;color:var(--text-muted);font-size:12.5px;">No tasks here</div>
      @endforelse
    </div>
  </div>

</div>{{-- /kanban --}}

{{-- Table View --}}
<div class="panel fade-up">
  <div class="panel-header"><span class="panel-title">All Tasks — Table View</span></div>
  @if($tasks->isEmpty())
    <div class="empty-state"><i class="bi bi-list-task"></i><p>No tasks found.</p></div>
  @else
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr><th>Task</th><th>Project</th><th>Priority</th><th>Status</th><th>Due Date</th><th style="text-align:center;">Actions</th></tr>
      </thead>
      <tbody>
        @foreach($tasks as $task)
        <tr>
          <td class="td-name">{{ $task->title }}</td>
          <td style="font-size:13px;">{{ $task->project->title ?? '—' }}</td>
          <td><span class="priority-tag {{ $task->priority }}">{{ ucfirst($task->priority) }}</span></td>
          <td><span class="status-badge {{ $task->statusBadgeClass() }}"><span class="status-dot"></span>{{ $task->statusLabel() }}</span></td>
          <td style="font-size:12.5px;color:var(--text-muted);">{{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}</td>
          <td>
            <div class="actions-cell" style="justify-content:center;">
              <a href="{{ route('admin.tasks.edit',$task) }}" class="act-btn edit"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.tasks.destroy',$task) }}" style="display:inline;"
                    onsubmit="return confirm('Delete \'{{ addslashes($task->title) }}\'?')">
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

@endsection

@push('scripts')
<script>
const BASE_URL = '{{ url('') }}';
const CSRF     = '{{ csrf_token() }}';

$(document).on('change', '.task-status-select', function () {
  const taskId    = $(this).data('task-id');
  const newStatus = $(this).val();
  $.ajax({
    url:  BASE_URL + '/admin/tasks/' + taskId + '/status',
    type: 'PATCH',
    data: { status: newStatus, _token: CSRF },
    success: function (res) {
      if (res.success) Toast.show('Status updated!', 'success');
    },
    error: function () { Toast.show('Update failed.', 'error'); }
  });
});
</script>
@endpush
