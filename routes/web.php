<?php
require __DIR__ . '/auth.php';

use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('/tasks/create-bulk', [TaskController::class, 'createBulk'])->name('tasks.create.bulk');
    Route::get('/tasks/archived', [TaskController::class, 'archived'])->name('tasks.archived');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::post('/tasks/bulk', [TaskController::class, 'storeBulk'])->name('tasks.store.bulk');
    Route::post('/tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
    Route::delete('/tasks/{id}/force-delete', [TaskController::class, 'forceDelete'])->name('tasks.force.delete');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update.status');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});



