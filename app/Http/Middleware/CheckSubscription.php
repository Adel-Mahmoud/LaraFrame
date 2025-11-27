<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $scheme = $request->getScheme(); // http أو https
        $host = $request->getHost();     // 127.0.0.1
        $port = $request->getPort();     // 7000

        $domain = "{$scheme}://{$host}";
        if ($port && !in_array($port, [80, 443])) {
            $domain .= ":{$port}";
        }
        // \\\\\\
        // $response = Http::get("http://127.0.0.1:9000/api/subscription/check/{$domain}");

        // $responseData = $response->json();
        // if (!$response->successful() || ($responseData['data']['status'] ?? null) !== 'active') {
        //     abort(403, 'اشتراكك غير فعال أو غير موجود.');
        // }
        // \\\\\\\\\\\\
        // $cacheKey = 'subscription_' . md5($domain);

        // $subscription = Cache::remember($cacheKey, now()->addDay(), function () use ($domain) {
        //     $response = Http::get("http://127.0.0.1:9000/api/subscription/check/{$domain}");
        //     $data = $response->json()['data'] ?? null;

        //     if (!$response->successful() || ($data['status'] ?? null) !== 'active') {
        //         return null;
        //     }

        //     return $data;
        // });
        // \\\\\\\
        // $subscription = $responseData['data'];
        // $request->attributes->set('subscription', $subscription);

        return $next($request);
    }
}
