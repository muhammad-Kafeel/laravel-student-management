<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Check if the logged-in user is an admin.
     * If not, redirect them to the dashboard with an error message.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND is an admin
        if (Auth::check() && Auth::user()->isAdmin()) {
            // User is admin, allow access
            return $next($request);
        }

        // User is NOT admin, redirect to dashboard with error message
        return redirect()->route('dashboard')->with('error', 'Access Denied! Only admins can access this page.');
    }
}
