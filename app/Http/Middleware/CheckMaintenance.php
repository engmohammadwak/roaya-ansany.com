<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class CheckMaintenance
{
    public function handle(Request $request, Closure $next)
    {
        if (
            $request->is('admin*') ||
            $request->is('login*') ||
            $request->is('livewire*') ||
            $request->is('up')
        ) {
            return $next($request);
        }

        if (Setting::get('maintenance_mode') === '1') {
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
