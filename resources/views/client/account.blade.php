@extends('layouts.app')
@section('title','My Account')

@section('content')
<div class="row g-3 fade-up">

  {{-- Profile Card --}}
  <div class="col-lg-4">
    <div class="panel" style="text-align:center;padding:28px;">
      <div style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#34D399,#059669);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:#fff;margin:0 auto 12px;">
        {{ substr($user->name,0,1) }}
      </div>
      <div style="font-family:var(--font-head);font-size:17px;font-weight:700;">{{ $user->name }}</div>
      <div style="font-size:12.5px;color:var(--text-muted);margin-bottom:12px;">{{ $user->email }}</div>
      <span class="status-badge in-progress"><span class="status-dot"></span>Active Client</span>
      @if($user->company)
        <div style="margin-top:10px;font-size:12.5px;color:var(--text-secondary);"><i class="bi bi-building"></i> {{ $user->company }}</div>
      @endif
    </div>
  </div>

  <div class="col-lg-8">
    @if($errors->any())
      <div class="flash-alert alert-error-custom" style="display:flex;margin-bottom:14px;">
        <i class="bi bi-exclamation-triangle-fill"></i><span>{{ $errors->first() }}</span>
      </div>
    @endif

    {{-- Edit Profile --}}
    <div class="panel" style="margin-bottom:14px;">
      <div class="panel-header">
        <span class="panel-title"><i class="bi bi-person-circle" style="color:var(--accent);margin-right:6px;"></i>Edit Profile</span>
      </div>
      <div style="padding:20px;">
        <form method="POST" action="{{ route('client.account.profile') }}">
          @csrf
          <div class="form-group">
            <label class="form-label-st">Full Name</label>
            <input type="text" name="name" class="form-control-st" value="{{ old('name',$user->name) }}" required/>
          </div>
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label-st">Email (read-only)</label>
              <input type="email" class="form-control-st" value="{{ $user->email }}" disabled style="opacity:.6;"/>
            </div>
            <div class="form-group">
              <label class="form-label-st">Phone</label>
              <input type="tel" name="phone" class="form-control-st" value="{{ old('phone',$user->phone) }}" placeholder="03XX-XXXXXXX"/>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label-st">Company</label>
            <input type="text" name="company" class="form-control-st" value="{{ old('company',$user->company) }}" placeholder="Optional"/>
          </div>
          <button type="submit" class="btn-primary"><i class="bi bi-save2"></i> Save Changes</button>
        </form>
      </div>
    </div>

    {{-- Change Password --}}
    <div class="panel">
      <div class="panel-header">
        <span class="panel-title"><i class="bi bi-lock" style="color:var(--accent-blue);margin-right:6px;"></i>Change Password</span>
      </div>
      <div style="padding:20px;">
        <form method="POST" action="{{ route('client.account.password') }}">
          @csrf
          <div class="form-group">
            <label class="form-label-st">Current Password</label>
            <input type="password" name="current_password" class="form-control-st {{ $errors->has('current_password')?'is-invalid':'' }}" required/>
          </div>
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label-st">New Password</label>
              <input type="password" name="new_password" class="form-control-st" placeholder="Min. 6 characters" required/>
            </div>
            <div class="form-group">
              <label class="form-label-st">Confirm Password</label>
              <input type="password" name="new_password_confirmation" class="form-control-st" required/>
            </div>
          </div>
          <button type="submit" class="btn-primary blue"><i class="bi bi-lock"></i> Update Password</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
