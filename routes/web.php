<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Events\EventChatroom;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CurriculumController;

Route::get('/', function () {
    return view('home');
});

Route::middleware('auth')->group(function () {
    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export-all-events', [DashboardController::class, 'exportAllEvents'])->name('dashboard.export-all-events');
    
    //user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/preferences', [ProfileController::class, 'preferences'])->name('profile.preferences');
    Route::post('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.update-preferences');
    
    //events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');         
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create'); 
    Route::post('/events', [EventController::class, 'store'])->name('events.store');       
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/signup', [EventController::class, 'signup'])->name('events.signup'); 
    Route::get('/events/{event}/export', [EventController::class, 'export'])->name('events.export');
    Route::get('/events/{event}/chat', [EventController::class, 'chat'])->name('events.chat');
    
    //curricula
    Route::post('/curricula', [CurriculumController::class, 'store'])->name('curricula.store');
    
    //ai content generation
    Route::get('/ai/generate', [App\Http\Controllers\AIContentController::class, 'generate'])->name('ai.generate');
});

require __DIR__.'/auth.php';
