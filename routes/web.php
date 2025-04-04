<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');         
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create'); 
    Route::post('/events', [EventController::class, 'store'])->name('events.store');       
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');    
    Route::post('/events/{event}/signup', [EventController::class, 'signup'])->name('events.signup'); 
});

require __DIR__.'/auth.php';
