<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AIContentController;

// ✅ AI summary generation route
Route::post('/generate-ai-summary', [AIContentController::class, 'generate'])->name('generate.ai.summary');

// PDF upload routes (if used)
Route::get('/upload', function () {
    return view('upload');
});

Route::post('/process-pdf', [PdfController::class, 'process'])->name('process.pdf');

// Home
Route::get('/', function () {
    return view('home');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Protected Routes
Route::middleware('auth')->group(function () {

    // ✅ User Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::post('/events/{event}/signup', [EventController::class, 'signup'])->name('events.signup');

    // ✅ Curricula
    Route::post('/curricula', [CurriculumController::class, 'store'])->name('curricula.store');
});

require __DIR__.'/auth.php';
