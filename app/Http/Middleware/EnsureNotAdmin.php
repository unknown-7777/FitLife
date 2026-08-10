<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();


        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}