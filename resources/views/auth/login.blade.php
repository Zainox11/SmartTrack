{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — SmartTrack</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}"/>
</head>
<body class="auth-page">

{{-- Brand Panel --}}
<div class="auth-brand">
  <div class="auth-logo">
    <div class="auth-logo-mark">
      <svg viewBox="0 0 24 24" fill="none" width="22" height="22">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div><div class="auth-logo-name">SmartTrack</div><div class="auth-logo-tag">AGENCY PORTAL</div></div>
  </div>
  <div class="auth-tagline">Manage Projects.<br/><span class="hl">Track Progress.</span><br/>Deliver Results.</div>
  <p class="auth-desc">Complete agency & client project management. Assign tasks, track deadlines, and keep clients updated — all in one place.</p>
  <div class="auth-feats">
    <div class="auth-feat"><div class="auth-feat-icon">⚡</div>Real-time AJAX task updates</div>
    <div class="auth-feat"><div class="auth-feat-icon">🔐</div>Role-based Admin & Client portals</div>
    <div class="auth-feat"><div class="auth-feat-icon">📁</div>Full project & task CRUD</div>
    <div class="auth-feat"><div class="auth-feat-icon">📊</div>Live progress tracking</div>
  </div>
</div>

{{-- Form Panel --}}
<div class="auth-form-panel">
  <div class="auth-form-box">
    <h1 class="auth-form-title">Welcome back 👋</h1>
    <p class="auth-form-sub">Sign in to your SmartTrack account</p>

    {{-- Default credentials --}}
    <div class="default-creds">
      <strong>Admin:</strong> admin@smarttrack.com / password &nbsp;|&nbsp;
      <strong>Client:</strong> aisha@client.com / password
    </div>

    {{-- Errors --}}
    @if($errors->any())
      <div class="auth-error" style="display:flex;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span>{{ $errors->first() }}</span>
      </div>
    @endif

    {{-- Role selector --}}
    <div class="role-row">
      <div class="role-option selected" id="roleAdmin" onclick="setRole('admin')">
        <span class="r-icon">🛡️</span><div class="r-name">Admin</div><div class="r-desc">Agency owner</div>
      </div>
      <div class="role-option" id="roleClient" onclick="setRole('client')">
        <span class="r-icon">👤</span><div class="r-name">Client</div><div class="r-desc">View my projects</div>
      </div>
    </div>

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="input-grp">
        <label class="input-label">Email Address</label>
        <div class="input-wrap">
          <input type="email" name="email" id="emailField" class="auth-input {{ $errors->has('email') ? 'is-invalid':'' }}"
                 placeholder="admin@smarttrack.com" value="{{ old('email','admin@smarttrack.com') }}" required/>
          <i class="bi bi-envelope ii"></i>
        </div>
      </div>
      <div class="input-grp">
        <label class="input-label">Password</label>
        <div class="input-wrap">
          <input type="password" name="password" id="pwdField" class="auth-input" placeholder="password" required/>
          <i class="bi bi-lock ii"></i>
          <button type="button" class="pwd-btn" onclick="togglePwd()"><i class="bi bi-eye" id="pwdIcon"></i></button>
        </div>
      </div>
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
        <label class="check-label" style="font-size:12.5px;color:var(--text-secondary);display:flex;align-items:center;gap:6px;">
          <input type="checkbox" name="remember" style="accent-color:var(--accent);"> Remember me
        </label>
      </div>
      <button type="submit" class="btn-auth"><i class="bi bi-box-arrow-in-right"></i> Sign In to Dashboard</button>
    </form>

    <div class="auth-footer">&copy; {{ date('Y') }} SmartTrack — NAVTTC Advanced Web Development</div>
  </div>
</div>

<script>
function setRole(r){
  document.getElementById('roleAdmin').classList.toggle('selected',r==='admin');
  document.getElementById('roleClient').classList.toggle('selected',r==='client');
  document.getElementById('emailField').value=r==='admin'?'admin@smarttrack.com':'aisha@client.com';
}
function togglePwd(){
  const f=document.getElementById('pwdField'),i=document.getElementById('pwdIcon');
  f.type=f.type==='password'?'text':'password';
  i.className=f.type==='password'?'bi bi-eye':'bi bi-eye-slash';
}
</script>
</body>
</html>
