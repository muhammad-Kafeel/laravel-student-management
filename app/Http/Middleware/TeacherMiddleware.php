<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Check if the logged-in user is an admin OR teacher.
     * Students are NOT allowed.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND is either admin or teacher
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isTeacher())) {
            // User is admin or teacher, allow access
            return $next($request);
        }

        // User is NOT admin/teacher (probably student), redirect to dashboard with error message
        return redirect()->route('dashboard')->with('error', 'Access Denied! Only admins and teachers can access this page.');
    }
}
