<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AIContentController;

// Define the POST route for AI summary generation
Route::post('/generate-ai-summary', [AIContentController::class, 'generate'])->name('generate.ai.summary');

// Existing routes for uploading PDF and processing
Route::get('/upload', function () {
    return view('upload');
});

Route::post('/process-pdf', [PdfController::class, 'process'])->name('process.pdf');

// Default routes
Route::get('/', function () {
    return view('home');
});

// Dashboard route with middleware protection
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // User profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Event-related routes
    Route::get('/events', [EventController::class, 'index'])->name('events.index');         
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create'); 
    Route::post('/events', [EventController::class, 'store'])->name('events.store');       
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');    
    Route::post('/events/{event}/signup', [EventController::class, 'signup'])->name('events.signup'); 
    
    // Curriculum-related routes
    Route::post('/curricula', [CurriculumController::class, 'store'])->name('curricula.store');
});

require __DIR__.'/auth.php';
