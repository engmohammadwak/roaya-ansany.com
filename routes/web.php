<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\ProjectController;
use App\Models\BlogPage;
use Illuminate\Support\Facades\Route;

// حل خطأ: Route [login] not defined
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// Redirect root to default locale
Route::get('/', function () {
    return redirect('/' . app()->getLocale());
});

// Paymob webhook (بدون CSRF — webhook خارجي)
Route::post('/donate/payment/callback', [PaymentController::class, 'callback'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('payment.callback.global');

// Localized routes
Route::prefix('{locale}')
    ->where(['locale' => 'ar|en'])
    ->middleware('setlocale')
    ->group(function () {

        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::get('/about', [AboutController::class, 'index'])->name('about');

        // روابط المدونة — تُحجب تلقائياً لو is_active = false
        Route::get('/blogs', function () use (&$locale) {
            if (!BlogPage::isEnabled()) abort(404);
            return app(BlogController::class)->index();
        })->name('blogs');
        Route::get('/blogs/{slug}', function ($locale, $slug) {
            if (!BlogPage::isEnabled()) abort(404);
            return app(BlogController::class)->show($slug);
        })->name('blogs.show');

        Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns');
        Route::get('/campaigns/{slug}', [CampaignController::class, 'show'])->name('campaigns.show');

        Route::get('/donate', [DonateController::class, 'index'])->name('donate');

        // طلب الدفع — محمي بـ rate limiter (ماكس 5 محاولات / 10 دقائق)
        Route::post('/donate/payment/3d/form', [PaymentController::class, 'process'])
            ->middleware('payment.limit')
            ->name('payment.process');

        Route::get('/donate/payment/result', [PaymentController::class, 'result'])->name('payment.result');

        Route::post('/donate/payment/callback', [PaymentController::class, 'callback'])
            ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
            ->name('payment.callback');

        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])
            ->middleware('throttle:20,1')
            ->name('contact.store');
        Route::post('/contact/send', [ContactController::class, 'send'])
            ->middleware('throttle:20,1')
            ->name('contact.send');

        Route::get('/faq',      [FaqController::class, 'index'])->name('faq');
        Route::get('/programs', [ProgramController::class, 'index'])->name('programs');
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.local');

        Route::get('/privacy-policy',       [PrivacyController::class, 'index'])->name('privacy');
        Route::get('/terms-of-use',         [TermsController::class, 'index'])->name('terms');
        Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms.old');
    });
