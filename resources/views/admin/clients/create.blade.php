@extends('layouts.app')
@section('title','Add Client')

@section('content')
<div class="row justify-content-center fade-up">
  <div class="col-lg-7">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
      <a href="{{ route('admin.clients.index') }}" class="btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      <h2 style="font-family:var(--font-head);font-size:18px;font-weight:700;margin:0;">Add New Client</h2>
    </div>

    @if($errors->any())
      <div class="flash-alert alert-error-custom" style="display:flex;">
        <i class="bi bi-exclamation-triangle-fill"></i><span>{{ $errors->first() }}</span>
      </div>
    @endif

    <div class="panel">
      <div class="panel-header">
        <span class="panel-title"><i class="bi bi-person-plus" style="color:var(--accent);margin-right:6px;"></i>Client Details</span>
      </div>
      <div style="padding:22px;">
        <form method="POST" action="{{ route('admin.clients.store') }}">
          @csrf
          <div class="form-group">
            <label class="form-label-st">Full Name <span style="color:#EF4444;">*</span></label>
            <input type="text" name="name" class="form-control-st" value="{{ old('name') }}" placeholder="Ahmed Khan" required/>
          </div>
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label-st">Email Address <span style="color:#EF4444;">*</span></label>
              <input type="email" name="email" class="form-control-st {{ $errors->has('email')?'is-invalid':'' }}"
                     value="{{ old('email') }}" placeholder="client@email.com" required/>
            </div>
            <div class="form-group">
              <label class="form-label-st">Phone</label>
              <input type="tel" name="phone" class="form-control-st" value="{{ old('phone') }}" placeholder="03XX-XXXXXXX"/>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label-st">Company / Business</label>
            <input type="text" name="company" class="form-control-st" value="{{ old('company') }}" placeholder="Optional"/>
          </div>
          <div class="form-group">
            <label class="form-label-st">Password <span style="color:#EF4444;">*</span></label>
            <input type="password" name="password" class="form-control-st" placeholder="Min. 6 characters" required/>
            <span style="font-size:11.5px;color:var(--text-muted);margin-top:4px;display:block;">Client will use this to login.</span>
          </div>
          <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-primary"><i class="bi bi-person-plus"></i> Add Client</button>
            <a href="{{ route('admin.clients.index') }}" class="btn-ghost">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
