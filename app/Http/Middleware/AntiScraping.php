<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AntiScraping
{
    /**
     * Known bot user agents to block
     */
    protected $blockedBots = [
        'scrapy',
        'python-requests',
        'curl',
        'wget',
        'httpclient',
        'axios',
        'go-http-client',
        'java',
        'okhttp',
        'apache-httpclient',
        'selenium',
        'phantomjs',
        'headless',
        'bot',
        'crawler',
        'spider',
    ];

    /**
     * Allowed bots (search engines)
     */
    protected $allowedBots = [
        'googlebot',
        'bingbot',
        'slurp', // Yahoo
        'duckduckbot',
        'baiduspider',
        'yandexbot',
        'facebookexternalhit',
        'twitterbot',
        'whatsapp',
        'telegram',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $userAgent = strtolower($request->userAgent() ?? '');

        // 1. Check if allowed bot (search engines)
        foreach ($this->allowedBots as $bot) {
            if (str_contains($userAgent, $bot)) {
                return $next($request);
            }
        }

        // 2. Block known scraping tools
        foreach ($this->blockedBots as $bot) {
            if (str_contains($userAgent, $bot)) {
                Log::warning('Blocked scraping attempt', [
                    'ip' => $ip,
                    'user_agent' => $userAgent,
                    'url' => $request->fullUrl(),
                ]);
                
                return response()->json([
                    'error' => 'Access denied',
                    'message' => 'Automated access is not allowed'
                ], 403);
            }
        }

        // 3. Block empty user agents
        if (empty($userAgent)) {
            Log::warning('Blocked empty user agent', ['ip' => $ip]);
            return response()->json(['error' => 'Access denied'], 403);
        }

        // 4. Rate limiting - requests per minute
        $key = 'rate_limit:' . $ip;
        $requests = Cache::get($key, 0);
        
        if ($requests > 60) { // Max 60 requests per minute
            Log::warning('Rate limit exceeded', [
                'ip' => $ip,
                'requests' => $requests,
            ]);
            
            return response()->json([
                'error' => 'Too many requests',
                'message' => 'Please slow down'
            ], 429);
        }
        
        Cache::put($key, $requests + 1, 60); // Increment for 1 minute

        // 5. Check for suspicious patterns
        $suspiciousPatterns = [
            '/\.json$/',
            '/\.xml$/',
            '/\/api\//',
            '/download/',
            '/export/',
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $request->path())) {
                $dailyKey = 'suspicious:' . $ip . ':' . date('Y-m-d');
                $count = Cache::get($dailyKey, 0);
                
                if ($count > 10) { // Max 10 suspicious requests per day
                    Log::warning('Suspicious activity blocked', [
                        'ip' => $ip,
                        'pattern' => $pattern,
                        'url' => $request->fullUrl(),
                    ]);
                    
                    return response()->json(['error' => 'Access denied'], 403);
                }
                
                Cache::put($dailyKey, $count + 1, 86400); // 24 hours
            }
        }

        // 6. Check for rapid sequential requests (bot behavior)
        $sequenceKey = 'sequence:' . $ip;
        $lastRequest = Cache::get($sequenceKey);
        
        if ($lastRequest && (microtime(true) - $lastRequest) < 0.5) { // Less than 0.5 seconds
            $rapidKey = 'rapid:' . $ip;
            $rapidCount = Cache::get($rapidKey, 0);
            
            if ($rapidCount > 5) { // 5 rapid requests in a row
                Log::warning('Rapid requests blocked', ['ip' => $ip]);
                return response()->json(['error' => 'Too fast'], 429);
            }
            
            Cache::put($rapidKey, $rapidCount + 1, 300); // 5 minutes
        }
        
        Cache::put($sequenceKey, microtime(true), 60);

        return $next($request);
    }
}
