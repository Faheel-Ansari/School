<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventCache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // Get the response from the next middleware or controller
       $response = $next($request);

       // Prevent caching by setting appropriate headers
       return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                       ->header('Pragma', 'no-cache')
                       ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}
