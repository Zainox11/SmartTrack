<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') — {{ config('app.name','SmartTrack') }}</title>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>

  {{-- SmartTrack CSS --}}
  <link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/topbar.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/cards.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/buttons.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/tables.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/modals.css') }}"/>

  @stack('styles')
</head>
<body>
<div class="app-shell">

  {{-- Sidebar --}}
  @include('layouts.sidebar')

  {{-- Main --}}
  <div class="main-content">

    {{-- Topbar --}}
    @include('layouts.topbar')

    {{-- Page Content --}}
    <div class="page-content">

      {{-- Flash messages --}}
      @include('layouts.flash')

      {{-- Page body --}}
      @yield('content')

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

@stack('scripts')
</body>
</html>
