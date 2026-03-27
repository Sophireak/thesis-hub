<?php

use App\Http\Controllers\ProfileController;
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
// Supervisor routes
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
    Route::resource('projects', App\Http\Controllers\Student\ProjectController::class);
    Route::post('/projects/{project}/add-member', [App\Http\Controllers\Student\ProjectController::class, 'addMember'])->name('projects.addMember');
    Route::delete('/projects/{project}/remove-member/{user}', [App\Http\Controllers\Student\ProjectController::class, 'removeMember'])->name('projects.removeMember');

    Route::resource('projects.milestones', App\Http\Controllers\Student\MilestoneController::class)->shallow();
});
// Profile routes (from Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
