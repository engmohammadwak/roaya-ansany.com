<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

// Redirect root to default locale
Route::get('/', function () {
    return redirect('/' . app()->getLocale());
});

// Localized routes
Route::prefix('{locale}')
    ->where(['locale' => 'ar|en'])
    ->middleware('setlocale')
    ->group(function () {

        Route::get('/', [HomeController::class, 'index'])->name('home');

        // About
        Route::get('/about', [AboutController::class, 'index'])->name('about');

        // Blogs
        Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
        Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

        // Campaigns — يستخدم slug بدل id للـ SEO
        Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns');
        Route::get('/campaigns/{slug}', [CampaignController::class, 'show'])->name('campaigns.show');

        // Donate
        Route::get('/donate', [DonateController::class, 'index'])->name('donate');

        // Contact
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
        Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

        // FAQ
        Route::get('/faq', [FaqController::class, 'index'])->name('faq');

        // Programs
        Route::get('/programs', [ProgramController::class, 'index'])->name('programs');

        // Projects (local DB)
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.local');

        // Static pages
        Route::get('/privacy-policy', [PrivacyController::class, 'index'])->name('privacy');
        Route::get('/terms-of-use',   [TermsController::class, 'index'])->name('terms');
        Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms.old');
    });
