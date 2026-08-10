<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->isAdmin()) 
        {
            return $next($request);
        }

        if ($request->routeIs('profile.setup') ||
            $request->routeIs('profile.setup.save') ||
            $request->routeIs('logout')) {
            return $next($request);
        }

        if ($user && !$user->profile) {
            return redirect()->route('profile.setup');
        }

        return $next($request);
    }
}