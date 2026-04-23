{{-- resources/views/layouts/sidebar.blade.php --}}

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">

  <div class="sidebar-logo">
    <div class="logo-mark">
      <svg viewBox="0 0 24 24" fill="none" width="18" height="18">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
              stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="logo-wordmark">
      <span class="logo-name">SmartTrack</span>
      <span class="logo-ai">{{ auth()->user()->isAdmin() ? 'ADMIN' : 'CLIENT' }}</span>
    </div>
  </div>

  <nav class="sidebar-nav">

    @if(auth()->user()->isAdmin())
      {{-- Admin nav --}}
      <a href="{{ route('admin.dashboard') }}"
         class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill nav-icon"></i> Dashboard
      </a>
      <a href="{{ route('admin.projects.index') }}"
         class="nav-link {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
        <i class="bi bi-folder2-open nav-icon"></i> Projects
      </a>
      <a href="{{ route('admin.tasks.index') }}"
         class="nav-link {{ request()->routeIs('admin.tasks*') ? 'active' : '' }}">
        <i class="bi bi-list-task nav-icon"></i> Tasks
        @php $pendingCount = \App\Models\Task::where('status','todo')->count(); @endphp
        @if($pendingCount > 0)
          <span class="nav-badge red">{{ $pendingCount }}</span>
        @endif
      </a>
      <a href="{{ route('admin.clients.index') }}"
         class="nav-link {{ request()->routeIs('admin.clients*') ? 'active' : '' }}">
        <i class="bi bi-people-fill nav-icon"></i> Clients
      </a>
      <div class="nav-group-label">Management</div>
      <a href="{{ route('admin.requests.index') }}"
         class="nav-link {{ request()->routeIs('admin.requests*') ? 'active' : '' }}">
        <i class="bi bi-inbox-fill nav-icon"></i> Requests
        @php $reqCount = \App\Models\ProjectRequest::where('status','pending')->count(); @endphp
        @if($reqCount > 0)
          <span class="nav-badge red">{{ $reqCount }}</span>
        @endif
      </a>

    @else
      {{-- Client nav --}}
      <a href="{{ route('client.dashboard') }}"
         class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill nav-icon"></i> Dashboard
      </a>
      <a href="{{ route('client.projects') }}"
         class="nav-link {{ request()->routeIs('client.projects') ? 'active' : '' }}">
        <i class="bi bi-folder2-open nav-icon"></i> My Projects
      </a>
      <a href="{{ route('client.tasks') }}"
         class="nav-link {{ request()->routeIs('client.tasks') ? 'active' : '' }}">
        <i class="bi bi-list-task nav-icon"></i> My Tasks
      </a>
      <a href="{{ route('client.request') }}"
         class="nav-link {{ request()->routeIs('client.request') ? 'active' : '' }}">
        <i class="bi bi-send nav-icon"></i> New Request
      </a>
      <div class="nav-group-label">Account</div>
      <a href="{{ route('client.account') }}"
         class="nav-link {{ request()->routeIs('client.account') ? 'active' : '' }}">
        <i class="bi bi-person-circle nav-icon"></i> My Account
      </a>
    @endif

    <div class="nav-group-label">System</div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="nav-link logout" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;">
        <i class="bi bi-box-arrow-left nav-icon"></i> Logout
      </button>
    </form>

  </nav>

  <div class="sidebar-footer">
    <div class="user-card-sidebar">
      <div class="user-avatar-sidebar">{{ auth()->user()->initials() }}</div>
      <div>
        <div class="user-name-sidebar">{{ auth()->user()->name }}</div>
        <div class="user-role-sidebar">{{ ucfirst(auth()->user()->role) }}</div>
      </div>
    </div>
  </div>

</aside>
