<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\ProjectController;
use App\Http\Controllers\Student\MilestoneController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->isStudent()) {
        return redirect()->route('student.dashboard');
    } elseif (auth()->user()->isSupervisor()) {
        return redirect()->route('supervisor.dashboard');
    } elseif (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

// Student routes
Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
});

// Supervisor routes
Route::middleware(['auth'])->group(function () {
    Route::get('/supervisor/dashboard', function () {
        return view('supervisor.dashboard');
    })->name('supervisor.dashboard');
});

// Supervisor projects routes
Route::middleware(['auth'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/projects', function () {
        return view('supervisor.projects.index');
    })->name('projects');
});

// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Student Project Routes
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    // Project routes
    Route::resource('projects', ProjectController::class);
    Route::post('/projects/{project}/add-member', [ProjectController::class, 'addMember'])->name('projects.addMember');
    Route::delete('/projects/{project}/remove-member/{user}', [ProjectController::class, 'removeMember'])->name('projects.removeMember');
    Route::get('/projects/{project}/confirm-delete', [ProjectController::class, 'confirmDelete'])->name('projects.confirmDelete');
    Route::post('/projects/{project}/suspend', [ProjectController::class, 'suspend'])->name('projects.suspend');
    Route::post('/projects/{project}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::post('/projects/{project}/archive', [ProjectController::class, 'archive'])->name('projects.archive');

    // Milestone routes (explicit)
    Route::get('/projects/{project}/milestones/create', [MilestoneController::class, 'create'])->name('milestones.create');
    Route::post('/projects/{project}/milestones', [MilestoneController::class, 'store'])->name('milestones.store');
    Route::get('/milestones/{milestone}/edit', [MilestoneController::class, 'edit'])->name('milestones.edit');
    Route::put('/milestones/{milestone}', [MilestoneController::class, 'update'])->name('milestones.update');
    Route::delete('/milestones/{milestone}', [MilestoneController::class, 'destroy'])->name('milestones.destroy');
});

// Profile routes (from Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
