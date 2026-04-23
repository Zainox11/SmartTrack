{{-- resources/views/layouts/flash.blade.php --}}
@if(session('success'))
  <div class="flash-alert alert-success-custom">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    <button onclick="this.parentElement.remove()" style="background:none;border:none;float:right;cursor:pointer;">&times;</button>
  </div>
@endif

@if(session('error'))
  <div class="flash-alert alert-error-custom">
    <i class="bi bi-x-circle-fill"></i> {{ session('error') }}
    <button onclick="this.parentElement.remove()" style="background:none;border:none;float:right;cursor:pointer;">&times;</button>
  </div>
@endif

@if($errors->any())
  <div class="flash-alert alert-error-custom">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <span>{{ $errors->first() }}</span>
  </div>
@endif
