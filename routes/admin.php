<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\FormBuilderController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| All routes here are automatically prefixed with 'admin' and protected 
| by 'auth' + 'admin' middleware.
|
*/

// --- Dashboard & Core Pages ---
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/disbursed', [DashboardController::class, 'disbursed'])->name('disbursed');
Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');


// --- Question Bank Routes ---
// URL Prefix: /admin/questions/*
// Route Name: admin.questions.*
Route::prefix('questions')->name('questions.')->group(function () {
    
    // List & Create
    Route::get('/', [QuestionController::class, 'index'])->name('index');
    Route::get('/create', [QuestionController::class, 'create'])->name('create');
    Route::post('/store', [QuestionController::class, 'store'])->name('store');
    
    // Import
    Route::post('/import', [QuestionController::class, 'importQuestions'])->name('import');

    // Edit, Update & Delete
    Route::get('/{id}/edit', [QuestionController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [QuestionController::class, 'update'])->name('update');
    Route::delete('/{id}/delete', [QuestionController::class, 'destroy'])->name('destroy');
});


// --- Form Builder Routes ---
// URL Prefix: /admin/forms/*
// Route Name: admin.forms.*
// Route::prefix('forms')->name('forms.')->group(function () {
//     Route::get('/', [FormBuilderController::class, 'index'])->name('index');
//     Route::get('/create', [FormBuilderController::class, 'create'])->name('create');
//     Route::post('/store', [FormBuilderController::class, 'store'])->name('store');

// });

Route::resource('forms', FormBuilderController::class);


// --- Applicant Management ---
// URL Prefix: /admin/applicants/*
Route::prefix('applicants')->group(function () {
    // Note: If you want these named 'admin.applicants.approve' etc., add ->name('applicants.') above
    
    Route::get('/', [ApplicantController::class, 'index'])->name('applicants');
    
    // Actions
    Route::get('/approve/{id}', [ApplicantController::class, 'approveSubmission'])->name('approve');
    Route::get('/reject/{id}', [ApplicantController::class, 'rejectSubmission'])->name('reject');
    Route::post('/update-score/{id}', [ApplicantController::class, 'updateScore'])->name('update_score');
    Route::get('/details/{id}', [ApplicantController::class, 'getSubmissionDetails'])->name('applicant_details');
});

Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

Route::resource("profile", AdminController::class);