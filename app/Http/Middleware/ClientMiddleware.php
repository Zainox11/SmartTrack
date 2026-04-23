<?php
// app/Http/Middleware/ClientMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isClient()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Access denied.');
        }
        return $next($request);
    }
}
