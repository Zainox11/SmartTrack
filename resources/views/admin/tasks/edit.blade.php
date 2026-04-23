@extends('layouts.app')
@section('title','Edit Task')

@section('content')
<div class="row justify-content-center fade-up">
  <div class="col-lg-7">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
      <a href="{{ route('admin.tasks.index') }}" class="btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      <h2 style="font-family:var(--font-head);font-size:18px;font-weight:700;margin:0;">Edit Task</h2>
    </div>

    @if($errors->any())
      <div class="flash-alert alert-error-custom" style="display:flex;">
        <i class="bi bi-exclamation-triangle-fill"></i><span>{{ $errors->first() }}</span>
      </div>
    @endif

    <div class="panel">
      <div class="panel-header">
        <span class="panel-title"><i class="bi bi-pencil" style="color:var(--accent-blue);margin-right:6px;"></i>Task Details</span>
      </div>
      <div style="padding:22px;">
        <form method="POST" action="{{ route('admin.tasks.update',$task) }}">
          @csrf @method('PUT')
          <div class="form-group">
            <label class="form-label-st">Task Title <span style="color:#EF4444;">*</span></label>
            <input type="text" name="title" class="form-control-st" value="{{ old('title',$task->title) }}" required/>
          </div>
          <div class="form-group">
            <label class="form-label-st">Project <span style="color:#EF4444;">*</span></label>
            <select name="project_id" class="form-control-st" required>
              @foreach($projects as $p)
                <option value="{{ $p->id }}" {{ old('project_id',$task->project_id)==$p->id ? 'selected':'' }}>{{ $p->title }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label-st">Priority</label>
              <select name="priority" class="form-control-st">
                <option value="low"    {{ old('priority',$task->priority)==='low'    ? 'selected':'' }}>Low</option>
                <option value="medium" {{ old('priority',$task->priority)==='medium' ? 'selected':'' }}>Medium</option>
                <option value="high"   {{ old('priority',$task->priority)==='high'   ? 'selected':'' }}>High</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label-st">Status</label>
              <select name="status" class="form-control-st">
                <option value="todo"        {{ old('status',$task->status)==='todo'        ? 'selected':'' }}>To Do</option>
                <option value="in_progress" {{ old('status',$task->status)==='in_progress' ? 'selected':'' }}>In Progress</option>
                <option value="done"        {{ old('status',$task->status)==='done'        ? 'selected':'' }}>Done</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label-st">Due Date</label>
            <input type="date" name="due_date" class="form-control-st"
                   value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"/>
          </div>
          <div class="form-group">
            <label class="form-label-st">Description</label>
            <textarea name="description" class="form-control-st" rows="3">{{ old('description',$task->description) }}</textarea>
          </div>
          <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-primary blue"><i class="bi bi-save2"></i> Save Changes</button>
            <form method="POST" action="{{ route('admin.tasks.destroy',$task) }}" style="display:inline;"
                  onsubmit="return confirm('Delete this task?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-danger"><i class="bi bi-trash3"></i> Delete</button>
            </form>
            <a href="{{ route('admin.tasks.index') }}" class="btn-ghost">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
