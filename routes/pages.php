<?php

use Illuminate\Support\Facades\Route;

// ─── Static Pages ─────────────────────────────────────────────────────────
Route::prefix('{locale}')->where(['locale' => 'ar|en'])->group(function () {

    Route::get('/about',          [App\Http\Controllers\AboutController::class,   'index'])->name('about');
    Route::get('/contact',        [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
    Route::post('/contact/send',  [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');
    Route::get('/faq',            [App\Http\Controllers\FaqController::class,     'index'])->name('faq');
    Route::get('/blog',           [App\Http\Controllers\BlogController::class,    'index'])->name('blog.index');
    Route::get('/blog/{slug}',    [App\Http\Controllers\BlogController::class,    'show'])->name('blog.show');
    Route::get('/programs',       [App\Http\Controllers\ProgramController::class, 'index'])->name('programs');
    Route::get('/projects',       [App\Http\Controllers\ProjectController::class, 'index'])->name('projects.local');
    Route::get('/privacy-policy', [App\Http\Controllers\PrivacyController::class, 'index'])->name('privacy');
    Route::get('/terms-of-use',   [App\Http\Controllers\TermsController::class,   'index'])->name('terms');

});
