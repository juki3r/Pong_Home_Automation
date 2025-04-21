<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Main Controller
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [MainController::class, 'show_dashboard'])->name('dashboard');

    //SUBSCRIBE
    Route::post('/subscribe', [MainController::class, 'subscribe'])->name('subscribe');

    Route::get('/lights', [MainController::class, 'show_lights'])->name('lights');
});

Route::post('/update-light-status', [ApiController::class, 'updateLightStatus']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
