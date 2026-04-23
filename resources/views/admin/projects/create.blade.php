@extends('layouts.app')
@section('title','New Project')

@section('content')
@include('layouts.sidebar',['active'=>'projects'])
<div class="main-content">
@include('layouts.topbar',['title'=>'New Project'])
<div class="page-content">

<div class="row justify-content-center fade-up">
  <div class="col-lg-8">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
      <a href="{{ route('admin.projects.index') }}" class="btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      <h2 style="font-family:var(--font-head);font-size:18px;font-weight:700;margin:0;">New Project</h2>
    </div>

    <div class="panel">
      <div class="panel-header"><span class="panel-title"><i class="bi bi-folder-plus" style="color:var(--accent);margin-right:6px;"></i>Project Details</span></div>
      <div style="padding:22px;">
        <form method="POST" action="{{ route('admin.projects.store') }}">
          @csrf
          <div class="form-group">
            <label class="form-label-st">Project Title <span style="color:#EF4444;">*</span></label>
            <input type="text" name="title" class="form-control-st @error('title') is-invalid @enderror"
                   value="{{ old('title') }}" placeholder="e.g. E-Commerce Website" required/>
            @error('title')<span class="field-error">{{ $message }}</span>@enderror
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label-st">Assign Client <span style="color:#EF4444;">*</span></label>
              <select name="client_id" class="form-control-st @error('client_id') is-invalid @enderror" required>
                <option value="">Select Client</option>
                @foreach($clients as $c)
                <option value="{{ $c->id }}" {{ old('client_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>
                @endforeach
              </select>
              @error('client_id')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
              <label class="form-label-st">Status</label>
              <select name="status" class="form-control-st">
                @foreach(['not_started'=>'Not Started','in_progress'=>'In Progress','on_hold'=>'On Hold','completed'=>'Completed'] as $v=>$l)
                <option value="{{ $v }}" {{ old('status','not_started')===$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label-st">Budget (PKR)</label>
              <input type="number" name="budget" class="form-control-st" value="{{ old('budget') }}" min="0" placeholder="e.g. 50000"/>
            </div>
            <div class="form-group">
              <label class="form-label-st">Deadline</label>
              <input type="date" name="deadline" class="form-control-st" value="{{ old('deadline') }}"/>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label-st">Description</label>
            <textarea name="description" class="form-control-st" rows="4" placeholder="Project details and requirements...">{{ old('description') }}</textarea>
          </div>

          <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-primary"><i class="bi bi-folder-plus"></i> Create Project</button>
            <a href="{{ route('admin.projects.index') }}" class="btn-ghost">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
</div>
@endsection
