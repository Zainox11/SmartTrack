@extends('layouts.app')
@section('title','Edit Client')

@section('content')
<div class="row justify-content-center fade-up">
  <div class="col-lg-7">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px;">
      <a href="{{ route('admin.clients.index') }}" class="btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      <h2 style="font-family:var(--font-head);font-size:18px;font-weight:700;margin:0;">Edit Client</h2>
    </div>

    @if($errors->any())
      <div class="flash-alert alert-error-custom" style="display:flex;">
        <i class="bi bi-exclamation-triangle-fill"></i><span>{{ $errors->first() }}</span>
      </div>
    @endif

    <div class="panel">
      <div class="panel-header">
        <span class="panel-title"><i class="bi bi-person-gear" style="color:var(--accent-blue);margin-right:6px;"></i>Client Details</span>
      </div>
      <div style="padding:22px;">
        <form method="POST" action="{{ route('admin.clients.update',$client) }}">
          @csrf @method('PUT')
          <div class="form-group">
            <label class="form-label-st">Full Name <span style="color:#EF4444;">*</span></label>
            <input type="text" name="name" class="form-control-st" value="{{ old('name',$client->name) }}" required/>
          </div>
          <div class="form-group">
            <label class="form-label-st">Email (read-only)</label>
            <input type="email" class="form-control-st" value="{{ $client->email }}" disabled style="opacity:.6;"/>
          </div>
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label-st">Phone</label>
              <input type="tel" name="phone" class="form-control-st" value="{{ old('phone',$client->phone) }}" placeholder="03XX-XXXXXXX"/>
            </div>
            <div class="form-group">
              <label class="form-label-st">Company</label>
              <input type="text" name="company" class="form-control-st" value="{{ old('company',$client->company) }}" placeholder="Optional"/>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label-st">New Password <span style="color:var(--text-muted);font-weight:400;">(leave blank to keep current)</span></label>
            <input type="password" name="new_password" class="form-control-st" placeholder="Min. 6 characters"/>
          </div>
          <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-primary blue"><i class="bi bi-save2"></i> Save Changes</button>
            <a href="{{ route('admin.clients.index') }}" class="btn-ghost">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
