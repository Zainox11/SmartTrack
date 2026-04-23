@extends('layouts.app')
@section('title','New Request')

@section('content')
<div class="row g-3 fade-up">
  <div class="col-lg-7">
    <div style="margin-bottom:18px;">
      <h2 style="font-family:var(--font-head);font-size:18px;font-weight:700;margin:0;">Submit Project Request</h2>
      <div style="font-size:13px;color:var(--text-muted);margin-top:4px;">Describe your project and we'll get back to you.</div>
    </div>

    @if($errors->any())
      <div class="flash-alert alert-error-custom" style="display:flex;">
        <i class="bi bi-exclamation-triangle-fill"></i><span>{{ $errors->first() }}</span>
      </div>
    @endif

    <div class="panel">
      <div class="panel-header">
        <span class="panel-title"><i class="bi bi-send" style="color:var(--accent);margin-right:6px;"></i>Project Details</span>
      </div>
      <div style="padding:22px;">
        <form method="POST" action="{{ route('client.request.store') }}">
          @csrf
          <div class="form-group">
            <label class="form-label-st">Project Title <span style="color:#EF4444;">*</span></label>
            <input type="text" name="title" class="form-control-st {{ $errors->has('title')?'is-invalid':'' }}"
                   placeholder="e.g. E-Commerce Website" value="{{ old('title') }}" required/>
          </div>
          <div class="form-group">
            <label class="form-label-st">Description <span style="color:#EF4444;">*</span></label>
            <textarea name="description" class="form-control-st {{ $errors->has('description')?'is-invalid':'' }}"
                      rows="5" placeholder="Describe what you need..." required>{{ old('description') }}</textarea>
          </div>
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label-st">Budget (PKR)</label>
              <input type="number" name="budget" class="form-control-st" placeholder="e.g. 50000" value="{{ old('budget') }}" min="0"/>
            </div>
            <div class="form-group">
              <label class="form-label-st">Expected Deadline</label>
              <input type="date" name="deadline" class="form-control-st" value="{{ old('deadline') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}"/>
            </div>
          </div>
          <button type="submit" class="btn-primary"><i class="bi bi-send"></i> Submit Request</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <h2 style="font-family:var(--font-head);font-size:16px;font-weight:700;margin-bottom:14px;">My Requests</h2>
    @forelse($myRequests as $r)
    @php $cls=match($r->status){'approved'=>'approved','rejected'=>'rejected',default=>'pending'}; @endphp
    <div class="panel" style="margin-bottom:10px;">
      <div style="padding:14px 16px;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;margin-bottom:6px;">
          <div style="font-weight:600;font-size:14px;color:var(--text-primary);">{{ $r->title }}</div>
          <span class="status-badge {{ $cls }}" style="font-size:11px;padding:3px 8px;white-space:nowrap;"><span class="status-dot"></span>{{ ucfirst($r->status) }}</span>
        </div>
        <div style="font-size:12px;color:var(--text-muted);">
          Submitted {{ $r->created_at->format('M d, Y') }}
          {{ $r->budget ? ' &bull; PKR ' . number_format($r->budget) : '' }}
        </div>
      </div>
    </div>
    @empty
    <div class="empty-state"><i class="bi bi-inbox"></i><p>No requests submitted yet.</p></div>
    @endforelse
  </div>
</div>
@endsection
