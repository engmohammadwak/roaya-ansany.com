<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
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
        Route::get('/about', [AboutController::class, 'index'])->name('about');

        // Blogs
        Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
        Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

        // Campaigns
        Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns');
        Route::get('/campaigns/{id}', [CampaignController::class, 'show'])->name('campaigns.show');

        // Donate
        Route::get('/donate', [DonateController::class, 'index'])->name('donate');

        // Contact
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

        // Static pages
        Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
        Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms');
    });
