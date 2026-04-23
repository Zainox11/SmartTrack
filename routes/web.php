<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController  as AdminDash;
use App\Http\Controllers\Admin\ProjectController    as AdminProject;
use App\Http\Controllers\Admin\TaskController       as AdminTask;
use App\Http\Controllers\Admin\ClientController     as AdminClient;
use App\Http\Controllers\Admin\RequestController    as AdminRequest;
use App\Http\Controllers\Client\DashboardController as ClientDash;
use App\Http\Controllers\Client\ProjectController   as ClientProject;
use App\Http\Controllers\Client\TaskController      as ClientTask;
use App\Http\Controllers\Client\RequestController   as ClientRequest;
use App\Http\Controllers\Client\AccountController   as ClientAccount;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDash::class, 'index'])->name('dashboard');
    Route::resource('projects', AdminProject::class)->except(['show']);
    Route::resource('tasks', AdminTask::class)->except(['show']);
    Route::patch('/tasks/{task}/status', [AdminTask::class, 'updateStatus'])->name('tasks.status');
    Route::resource('clients', AdminClient::class)->except(['show']);
    Route::get('/requests', [AdminRequest::class, 'index'])->name('requests.index');
    Route::post('/requests/{request}/approve', [AdminRequest::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{request}/reject',  [AdminRequest::class, 'reject'])->name('requests.reject');
});

Route::middleware(['auth','client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDash::class, 'index'])->name('dashboard');
    Route::get('/projects',  [ClientProject::class, 'index'])->name('projects');
    Route::get('/tasks',     [ClientTask::class, 'index'])->name('tasks');
    Route::get('/request',   [ClientRequest::class, 'create'])->name('request.create');
    Route::post('/request',  [ClientRequest::class, 'store'])->name('request.store');
    Route::get('/account',   [ClientAccount::class, 'edit'])->name('account');
    Route::post('/account/profile',  [ClientAccount::class, 'updateProfile'])->name('account.profile');
    Route::post('/account/password', [ClientAccount::class, 'updatePassword'])->name('account.password');
});
