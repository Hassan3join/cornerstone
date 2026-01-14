<?php

use App\Http\Controllers\User\FormSubmissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController; // Import from new namespace
use App\Http\Controllers\ProfileController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');

// Standard Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/form/initiate-payment/{id}', [FormSubmissionController::class, 'initiatePayment'])->name('form.payment_init');
    Route::post('form/submit/{id}', [FormSubmissionController::class, 'submit'])->name('form.submit');
});

require __DIR__ . '/auth.php';