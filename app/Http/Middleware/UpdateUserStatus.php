<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->status !== 'online') {
            auth()->user()->update(['status' => 'online']);
        }

        return $next($request);
    }

    public function terminate($request, $response)
    {
        if (auth()->check() && auth()->user()->status !== 'offline') {
            auth()->user()->update(['status' => 'offline']);
        }
    }

}
