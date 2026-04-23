@extends('layouts.app')
@section('title','Requests')

@section('content')

{{-- Tabs --}}
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;" class="fade-up">
  @php
    $tab = request('tab','pending');
    $tabs = ['pending'=>$pending->count(), 'approved'=>$approved->count(), 'rejected'=>$rejected->count()];
  @endphp
  @foreach($tabs as $key=>$count)
    <a href="?tab={{ $key }}"
       style="padding:7px 16px;border-radius:20px;font-size:12.5px;font-weight:600;text-decoration:none;
              border:1.5px solid {{ $tab===$key ? 'var(--accent)':'var(--border)' }};
              background:{{ $tab===$key ? 'var(--accent)':'var(--bg-card)' }};
              color:{{ $tab===$key ? '#fff':'var(--text-secondary)' }};">
      {{ ucfirst($key) }} ({{ $count }})
    </a>
  @endforeach
</div>

@php $list = $tab==='approved' ? $approved : ($tab==='rejected' ? $rejected : $pending); @endphp

@if($list->isEmpty())
  <div class="empty-state fade-up"><i class="bi bi-inbox"></i><p>No {{ $tab }} requests.</p></div>
@else
  @foreach($list as $req)
  <div class="panel fade-up" style="margin-bottom:14px;">
    <div style="padding:18px 20px;">

      {{-- Header --}}
      <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:10px;">
        <div>
          <div style="font-family:var(--font-head);font-size:15px;font-weight:700;color:var(--text-primary);">
            {{ $req->title }}
          </div>
          <div style="font-size:12.5px;color:var(--text-muted);margin-top:3px;display:flex;align-items:center;gap:6px;">
            <span style="width:20px;height:20px;border-radius:50%;background:linear-gradient(135deg,var(--accent),#007B8A);display:inline-flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;">
              {{ substr($req->client->name,0,1) }}
            </span>
            {{ $req->client->name }} &bull; Submitted {{ $req->created_at->format('M d, Y') }}
          </div>
        </div>
        @php
          $cls = match($req->status){'approved'=>'approved','rejected'=>'rejected',default=>'pending'};
        @endphp
        <span class="status-badge {{ $cls }}"><span class="status-dot"></span>{{ ucfirst($req->status) }}</span>
      </div>

      {{-- Description --}}
      <p style="font-size:13.5px;color:var(--text-secondary);line-height:1.6;margin-bottom:12px;">
        {{ $req->description }}
      </p>

      {{-- Meta --}}
      <div style="display:flex;gap:20px;font-size:12.5px;color:var(--text-muted);flex-wrap:wrap;margin-bottom:10px;">
        @if($req->budget)
          <span><i class="bi bi-currency-rupee"></i> Budget: <strong>PKR {{ number_format($req->budget) }}</strong></span>
        @endif
        @if($req->deadline)
          <span><i class="bi bi-calendar3"></i> Deadline: <strong>{{ \Carbon\Carbon::parse($req->deadline)->format('M d, Y') }}</strong></span>
        @endif
      </div>

      {{-- Actions (only for pending) --}}
      @if($req->status === 'pending')
      <div style="display:flex;gap:8px;padding-top:12px;border-top:1px solid var(--border);">
        <form method="POST" action="{{ route('admin.requests.approve',$req) }}"
              onsubmit="return confirm('Approve and create project?')">
          @csrf
          <button type="submit"
                  style="background:linear-gradient(135deg,#10B981,#059669);border:none;color:#fff;padding:8px 18px;border-radius:8px;font-weight:600;font-size:13px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
            <i class="bi bi-check-lg"></i> Approve &amp; Create Project
          </button>
        </form>
        <form method="POST" action="{{ route('admin.requests.reject',$req) }}"
              onsubmit="return confirm('Reject this request?')">
          @csrf
          <button type="submit" class="btn-danger">
            <i class="bi bi-x-lg"></i> Reject
          </button>
        </form>
      </div>
      @endif

    </div>
  </div>
  @endforeach
@endif

@endsection
