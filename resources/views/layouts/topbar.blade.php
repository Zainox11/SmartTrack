{{-- resources/views/layouts/topbar.blade.php --}}
<header class="topbar">
  <div class="topbar-left">
    <button class="menu-toggle" id="menuToggle"><i class="bi bi-list"></i></button>
    <div>
      <div class="page-title">@yield('title','Dashboard')</div>
      <div class="breadcrumb-custom">Home &rsaquo; <span class="bc-active">@yield('title','Dashboard')</span></div>
    </div>
  </div>

  <div class="topbar-search">
    <i class="bi bi-search s-icon"></i>
    <input type="text" id="topbarSearch" placeholder="Search..."/>
  </div>

  <div class="topbar-right">
    <div class="topbar-divider"></div>
    <div class="topbar-user">
      <div class="topbar-user-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      <span class="topbar-user-name">{{ auth()->user()->name }}</span>
      <i class="bi bi-chevron-down topbar-user-chevron"></i>
    </div>
  </div>
</header>
