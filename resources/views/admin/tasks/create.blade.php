@extends('layouts.app')
@section('title','Add Task')

@section('content')
<div class="row justify-content-center fade-up">
  <div class="col-lg-7">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
      <a href="{{ route('admin.tasks.index') }}" class="btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      <h2 style="font-family:var(--font-head);font-size:18px;font-weight:700;margin:0;">Add New Task</h2>
    </div>

    @if($errors->any())
      <div class="flash-alert alert-error-custom" style="display:flex;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span>{{ $errors->first() }}</span>
      </div>
    @endif

    <div class="panel">
      <div class="panel-header">
        <span class="panel-title"><i class="bi bi-plus-circle" style="color:var(--accent-purple);margin-right:6px;"></i>Task Details</span>
      </div>
      <div style="padding:22px;">
        <form method="POST" action="{{ route('admin.tasks.store') }}">
          @csrf
          <div class="form-group">
            <label class="form-label-st">Task Title <span style="color:#EF4444;">*</span></label>
            <input type="text" name="title" class="form-control-st {{ $errors->has('title') ? 'is-invalid' : '' }}"
                   placeholder="e.g. Design Homepage Mockup" value="{{ old('title') }}" required/>
          </div>
          <div class="form-group">
            <label class="form-label-st">Project <span style="color:#EF4444;">*</span></label>
            <select name="project_id" class="form-control-st" required>
              <option value="">Select Project</option>
              @foreach($projects as $p)
                <option value="{{ $p->id }}" {{ (old('project_id',$preProject) == $p->id) ? 'selected' : '' }}>
                  {{ $p->title }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label-st">Priority</label>
              <select name="priority" class="form-control-st">
                <option value="low"    {{ old('priority','medium')==='low'    ? 'selected':'' }}>Low</option>
                <option value="medium" {{ old('priority','medium')==='medium' ? 'selected':'' }}>Medium</option>
                <option value="high"   {{ old('priority','medium')==='high'   ? 'selected':'' }}>High</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label-st">Status</label>
              <select name="status" class="form-control-st">
                <option value="todo"        {{ old('status','todo')==='todo'        ? 'selected':'' }}>To Do</option>
                <option value="in_progress" {{ old('status')==='in_progress'        ? 'selected':'' }}>In Progress</option>
                <option value="done"        {{ old('status')==='done'               ? 'selected':'' }}>Done</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label-st">Due Date</label>
            <input type="date" name="due_date" class="form-control-st" value="{{ old('due_date') }}"/>
          </div>
          <div class="form-group">
            <label class="form-label-st">Description</label>
            <textarea name="description" class="form-control-st" rows="3" placeholder="Task details...">{{ old('description') }}</textarea>
          </div>
          <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-primary"><i class="bi bi-plus-lg"></i> Create Task</button>
            <a href="{{ route('admin.tasks.index') }}" class="btn-ghost">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
