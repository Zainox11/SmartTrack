# SmartTrack — Phase 4 (Laravel)

## Phase 3 se kya badla?

| Phase 3 (PHP OOP) | Phase 4 (Laravel) |
|---|---|
| Manual routing (URL → file path) | routes/web.php — named routes |
| Includes (header.php, footer.php) | Blade layouts (@extends, @yield) |
| OOP Classes (User.php etc.) | Eloquent Models (User, Project, Task) |
| Manual session auth | Laravel Auth (Auth::attempt) |
| Manual validation | $request->validate([...]) |
| Manual SQL queries | Eloquent ORM ($project->tasks()->count()) |
| Manual redirect | redirect()->route('admin.dashboard') |
| Manual flash messages | session('success') / with('success',...) |

---

## Laravel Concepts Used

| Concept | Kahan |
|---|---|
| **MVC** | Models (app/Models), Views (resources/views), Controllers (app/Http/Controllers) |
| **Routing** | routes/web.php — Route::resource(), Route::middleware() |
| **Blade Templates** | @extends, @yield, @section, @include, @foreach, @forelse |
| **Eloquent ORM** | User::where(), $project->tasks, belongsTo, hasMany |
| **Relationships** | User hasMany Projects, Project hasMany Tasks |
| **Middleware** | AdminMiddleware, ClientMiddleware — role-based access |
| **Request Validation** | $request->validate(['title'=>'required|string|max:200']) |
| **Named Routes** | route('admin.dashboard'), route('admin.projects.index') |
| **Route Model Binding** | function edit(Project $project) — auto finds by ID |
| **CSRF Protection** | @csrf in every form automatically |
| **Migrations** | database/migrations/*.php — create tables |
| **Seeders** | database/seeders/DatabaseSeeder.php — seed data |
| **Helper Functions** | auth(), route(), redirect(), session(), asset() |

---

## Project Structure

```
SmartTrack (Laravel)/
│
├── routes/
│   └── web.php                     All URL routes defined here
│
├── app/
│   ├── Models/
│   │   ├── User.php                Eloquent model + relationships
│   │   ├── Project.php             hasMany(Task), belongsTo(User)
│   │   ├── Task.php                belongsTo(Project)
│   │   └── ProjectRequest.php      belongsTo(User)
│   │
│   └── Http/
│       ├── Controllers/
│       │   ├── Auth/
│       │   │   └── LoginController.php
│       │   ├── Admin/
│       │   │   ├── DashboardController.php
│       │   │   ├── ProjectController.php   (Resource Controller)
│       │   │   ├── TaskController.php      (Resource + AJAX status)
│       │   │   ├── ClientController.php    (Resource Controller)
│       │   │   └── RequestController.php
│       │   └── Client/
│       │       ├── DashboardController.php
│       │       ├── ProjectController.php
│       │       ├── TaskController.php
│       │       ├── RequestController.php
│       │       └── AccountController.php
│       └── Middleware/
│           ├── AdminMiddleware.php
│           └── ClientMiddleware.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php       Master layout
│       │   ├── sidebar.blade.php   Navigation (admin + client)
│       │   ├── topbar.blade.php    Top bar
│       │   └── flash.blade.php     Success/error messages
│       ├── auth/
│       │   └── login.blade.php
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── projects/   index, create, edit
│       │   ├── tasks/      index, create, edit
│       │   ├── clients/    index, create, edit
│       │   └── requests/   index
│       └── client/
│           ├── dashboard.blade.php
│           ├── projects.blade.php
│           ├── tasks.blade.php
│           ├── request.blade.php
│           └── account.blade.php
│
└── database/
    ├── migrations/
    │   ├── ..._create_users_table.php
    │   ├── ..._create_projects_table.php
    │   ├── ..._create_tasks_table.php
    │   └── ..._create_requests_table.php
    └── seeders/
        └── DatabaseSeeder.php
```

---

## Setup — Fresh Laravel Install

### Step 1 — Laravel Install
```bash
composer create-project laravel/laravel SmartTrack
cd SmartTrack
```

### Step 2 — Copy these files into the project
```
Copy all files from this folder into your Laravel project
(overwrite existing files where prompted)
```

### Step 3 — Copy CSS/JS assets
```
Copy assets/css/ and assets/js/ to public/assets/
```

### Step 4 — .env configuration
```env
APP_NAME=SmartTrack
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smarttrack_db
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5 — Database setup
```bash
# Create database first in phpMyAdmin or MySQL:
CREATE DATABASE smarttrack_db;

# Then run migrations + seeders:
php artisan migrate
php artisan db:seed
```

### Step 6 — Register Middleware (bootstrap/app.php or Kernel.php)
```php
// In bootstrap/app.php (Laravel 11):
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin'  => \App\Http\Middleware\AdminMiddleware::class,
        'client' => \App\Http\Middleware\ClientMiddleware::class,
    ]);
})

// In app/Http/Kernel.php (Laravel 10):
protected $routeMiddleware = [
    'admin'  => \App\Http\Middleware\AdminMiddleware::class,
    'client' => \App\Http\Middleware\ClientMiddleware::class,
];
```

### Step 7 — Run
```bash
php artisan serve
# Open: http://localhost:8000
```

---

## Login Credentials

| Role   | Email                | Password |
|--------|----------------------|----------|
| Admin  | admin@smarttrack.com | password |
| Client | aisha@client.com     | password |
| Client | ahmed@client.com     | password |

---

## All 4 Phases Comparison

| | Phase 1 | Phase 2 | Phase 3 | Phase 4 |
|---|---|---|---|---|
| Storage | JSON files | MySQL | MySQL | MySQL |
| Backend Style | Procedural PHP | Procedural + mysqli | OOP Classes | Laravel Eloquent |
| Views | Plain HTML | Plain HTML | Plain HTML | Blade Templates |
| Routing | File paths | File paths | File paths | routes/web.php |
| Auth | Manual session | Manual session | Auth class | Laravel Auth |
| Validation | Manual if checks | Manual if checks | Manual | $request->validate() |
| ORM | None | Raw SQL | Static methods | Eloquent relationships |
