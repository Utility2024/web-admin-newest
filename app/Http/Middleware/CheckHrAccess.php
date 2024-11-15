<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckHrAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Check if user has access to 'esd' panel
        if ($user && ($user->isAdminHr() || $user->isSuperadmin()|| $user->isManagerAdmin())) {
            return $next($request);
        }

        // Redirect or abort if the user does not have access
        abort(403, 'Unauthorized action.');
    }
}
