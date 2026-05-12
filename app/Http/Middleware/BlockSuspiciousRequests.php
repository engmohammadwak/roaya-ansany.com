<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * BlockSuspiciousRequests
 * يفحص كل request عن:
 * - SQL Injection patterns
 * - XSS patterns
 * - Path Traversal (../ وغيره)
 * - Malicious User-Agents (بوتات و scanners)
 */
class BlockSuspiciousRequests
{
    // أنماط SQL Injection
    private array $sqlPatterns = [
        '/union\s+select/i',
        '/select\s+.*\s+from/i',
        '/insert\s+into/i',
        '/drop\s+table/i',
        '/delete\s+from/i',
        '/update\s+.*\s+set/i',
        '/exec\s*\(/i',
        '/INFORMATION_SCHEMA/i',
        '/benchmark\s*\(/i',
        '/sleep\s*\(/i',
        '/load_file\s*\(/i',
        "/'\s+or\s+'1'\s*=\s*'1/i",
        '/\'\s+or\s+1\s*=\s*1/i',
        '/;\s*drop/i',
        '/xp_cmdshell/i',
    ];

    // أنماط XSS
    private array $xssPatterns = [
        '/<script[^>]*>/i',
        '/javascript\s*:/i',
        '/on(load|click|mouseover|error|focus|blur)\s*=/i',
        '/eval\s*\(/i',
        '/document\.cookie/i',
        '/document\.write/i',
        '/<iframe/i',
        '/<object/i',
        '/<embed/i',
        '/vbscript\s*:/i',
        '/data\s*:\s*text\/html/i',
    ];

    // بوتات معروفة / scanners
    private array $badAgents = [
        'sqlmap', 'nikto', 'nmap', 'masscan', 'dirbuster', 'gobuster',
        'wfuzz', 'burpsuite', 'havij', 'acunetix', 'nessus', 'openvas',
        'zgrab', 'nuclei', 'hydra', 'medusa', 'w3af', 'whatweb',
        'python-requests', 'go-http-client', 'curl/', 'wget/',
    ];

    // مسارات خطيرة
    private array $dangerousPaths = [
        '../', '..\\', '%2e%2e', '%252e',
        '/etc/passwd', '/proc/self',
        'wp-admin', 'wp-login', 'phpmyadmin', 'phpinfo',
        '.env', '.git/', 'config.php', 'xmlrpc.php',
        '/admin.php', '/shell.php', '/backdoor',
    ];

    public function handle(Request $request, Closure $next)
    {
        $ua  = strtolower($request->userAgent() ?? '');
        $uri = strtolower($request->getRequestUri());

        // 1) فحص User-Agent
        foreach ($this->badAgents as $bot) {
            if (str_contains($ua, $bot)) {
                Log::warning('Blocked bad agent', ['ip' => $request->ip(), 'ua' => $ua, 'uri' => $uri]);
                return response()->json(['error' => 'Forbidden'], 403);
            }
        }

        // 2) فحص Path
        foreach ($this->dangerousPaths as $path) {
            if (str_contains($uri, $path)) {
                Log::warning('Blocked dangerous path', ['ip' => $request->ip(), 'uri' => $uri]);
                return response('Forbidden', 403);
            }
        }

        // 3) فحص جميع inputs لـ SQLi + XSS
        $input = json_encode($request->all());

        foreach ($this->sqlPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                Log::warning('Blocked SQL injection attempt', ['ip' => $request->ip(), 'uri' => $uri]);
                return response()->json(['error' => 'Invalid input detected'], 400);
            }
        }

        foreach ($this->xssPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                Log::warning('Blocked XSS attempt', ['ip' => $request->ip(), 'uri' => $uri]);
                return response()->json(['error' => 'Invalid input detected'], 400);
            }
        }

        return $next($request);
    }
}
