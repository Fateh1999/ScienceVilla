<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CountrySelection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): mixed  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Allowed country codes
        $countries = ['in', 'uk', 'us', 'ca', 'au'];

        // If the route already contains a country parameter, set cookie and continue
        if ($country = $request->route()?->parameter('country')) {
            $response = $next($request);
            // Store for 30 days
            return $response->withCookie(cookie('country', $country, 60 * 24 * 30));
        }

        // If user has selected country before, redirect them automatically
        $cookieCountry = $request->cookie('country');
        if ($cookieCountry && in_array($cookieCountry, $countries, true)) {
            return redirect("/{$cookieCountry}");
        }

        // Otherwise proceed (will hit the root route to show selection page)
        return $next($request);
    }
}
