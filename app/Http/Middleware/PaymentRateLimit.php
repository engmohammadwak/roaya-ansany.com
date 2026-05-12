<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * PaymentRateLimit
 * يمنع إرسال أكثر من 5 طلبات دفع في 10 دقائق من نفس IP
 * يحمي من هجمات توليد فيزات وهمية (carding attacks)
 */
class PaymentRateLimit
{
    const MAX_ATTEMPTS = 5;
    const DECAY_MINUTES = 10;

    public function handle(Request $request, Closure $next)
    {
        $ip  = $request->ip();
        $key = 'payment_limit:' . $ip;

        $attempts = (int) Cache::get($key, 0);

        if ($attempts >= self::MAX_ATTEMPTS) {
            Log::warning('Payment rate limit exceeded', [
                'ip'       => $ip,
                'attempts' => $attempts,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'تجاوزت عدد المحاولات المسموحة، يرجى المحاولة بعد ' . self::DECAY_MINUTES . ' دقائق.',
            ], 429);
        }

        Cache::put($key, $attempts + 1, now()->addMinutes(self::DECAY_MINUTES));

        return $next($request);
    }
}
