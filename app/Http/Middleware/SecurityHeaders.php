<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * SecurityHeaders Middleware
 * يجبر المتصفح على إجراءات أمان أساسية:
 * - X-Frame-Options       : منع Clickjacking
 * - X-Content-Type        : منع MIME Sniffing
 * - X-XSS-Protection      : حماية XSS للمتصفحات القديمة
 * - Referrer-Policy       : تقليل تسريب الروابط
 * - Permissions-Policy    : إيقاف APIs غير مستخدمة
 * - Content-Security-Policy: منع تنفيذ سكريبتات خارجية
 * - HSTS                  : إجبار HTTPS
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        // CSP: يسمح بالموارد من نفس الدومين فقط
        $response->headers->set('Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; " .
            "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; " .
            "img-src 'self' data: blob: https:; " .
            "connect-src 'self' https://accept.paymob.com https://ksa.paymob.com https://oman.paymob.com; " .
            "frame-src 'self' https://accept.paymob.com https://ksa.paymob.com https://oman.paymob.com; " .
            "object-src 'none';"
        );

        // إزالة الهيدر الذي يكشف نوع السيرفر
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
