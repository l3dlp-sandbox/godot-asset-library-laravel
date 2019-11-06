<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Tweak HTTP headers for better security.
 * See <https://www.danieldusek.com/blog/2/enabling-security-headers-for-your-website-with-php-and-laravel>.
 */
class SecureHeaders
{
    /**
     * The headers that should be added.
     */
    public const WANTED_HEADERS = [
        'Referrer-Policy' => 'no-referrer-when-downgrade',
        'X-Content-Type-Options' => 'nosniff',
        'X-XSS-Protection' => '1; mode=block',
        'X-Frame-Options' => 'DENY',
        'Strict-Transport-Security' => 'max-age=31536000',
        'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src * data:; font-src 'self' data:",
    ];

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        foreach (self::WANTED_HEADERS as $header => $value) {
            $response->headers->set($header, $value);
        }

        return $response;
    }
}
