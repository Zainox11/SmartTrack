@extends('layouts.app')
@section('title','Edit Project')

@section('content')
<div class="row g-3 fade-up">
  <div class="col-lg-8">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
      <a href="{{ route('admin.projects.index') }}" class="btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      <h2 style="font-family:var(--font-head);font-size:18px;font-weight:700;margin:0;">Edit Project</h2>
    </div>

    <div class="panel">
      <div class="panel-header"><span class="panel-title"><i class="bi bi-pencil-square" style="color:var(--accent-blue);margin-right:6px;"></i>Project Details</span></div>
      <div style="padding:22px;">
        <form method="POST" action="{{ route('admin.projects.update',$project) }}">
          @csrf @method('PUT')

          <div class="form-group">
            <label class="form-label-st">Project Title <span style="color:#EF4444;">*</span></label>
            <input type="text" name="title" class="form-control-st" value="{{ old('title',$project->title) }}" required/>
            @error('title')<span class="field-error">{{ $message }}</span>@enderror
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label-st">Assign Client</label>
              <select name="client_id" class="form-control-st" required>
                @foreach($clients as $c)
                <option value="{{ $c->id }}" {{ old('client_id',$project->client_id)==$c->id?'selected':'' }}>{{ $c->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label class="form-label-st">Status</label>
              <select name="status" class="form-control-st">
                @foreach(['not_started'=>'Not Started','in_progress'=>'In Progress','on_hold'=>'On Hold','completed'=>'Completed'] as $v=>$l)
                <option value="{{ $v }}" {{ old('status',$project->status)===$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label-st">Budget (PKR)</label>
              <input type="number" name="budget" class="form-control-st" value="{{ old('budget',$project->budget) }}" min="0"/>
            </div>
            <div class="form-group">
              <label class="form-label-st">Deadline</label>
              <input type="date" name="deadline" class="form-control-st" value="{{ old('deadline',$project->deadline?->format('Y-m-d')) }}"/>
            </div>
          </div>

          @php $pct = $project->progressPercent() @endphp
          <div class="form-group">
            <label class="form-label-st">Progress: {{ $pct }}% ({{ $project->tasks->where('status','done')->count() }}/{{ $project->tasks->count() }} tasks)</label>
            <div class="pb-wrap" style="width:100%;height:10px;"><div class="pb-fill" data-w="{{ $pct }}%" style="width:0;"></div></div>
          </div>

          <div class="form-group">
            <label class="form-label-st">Description</label>
            <textarea name="description" class="form-control-st" rows="4">{{ old('description',$project->description) }}</textarea>
          </div>

          <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-primary blue"><i class="bi bi-save2"></i> Save Changes</button>
            <a href="{{ route('admin.tasks.index',['project_id'=>$project->id]) }}" class="btn-ghost"><i class="bi bi-list-task"></i> Manage Tasks</a>
            <a href="{{ route('admin.projects.index') }}" class="btn-ghost">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Task list sidebar --}}
  <div class="col-lg-4">
    <div class="panel">
      <div class="panel-header">
        <span class="panel-title">Tasks ({{ $tasks->count() }})</span>
        <a href="{{ route('admin.tasks.create',['project_id'=>$project->id]) }}" class="btn-primary btn-sm"><i class="bi bi-plus-lg"></i></a>
      </div>
      <div style="padding:8px 14px;">
        @forelse($tasks as $t)
        <div style="display:flex;align-items:center;gap:8px;padding:9px 0;border-bottom:1px solid var(--border);">
          <span class="status-badge {{ $t->statusBadgeClass() }}" style="font-size:10.5px;padding:2px 7px;"><span class="status-dot"></span>{{ $t->statusLabel() }}</span>
          <span style="font-size:13px;flex:1;">{{ $t->title }}</span>
          <a href="{{ route('admin.tasks.edit',$t) }}" class="act-btn edit" style="width:24px;height:24px;font-size:12px;"><i class="bi bi-pencil"></i></a>
        </div>
        @empty
        <div class="empty-state" style="padding:20px 0;"><i class="bi bi-list-task"></i><p>No tasks yet.</p></div>
        @endforelse
      </div>
    </div>
  </div>
</div>

</div>
</div>
@endsection