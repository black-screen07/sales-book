<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckLevelAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('dashboard');
        }
        return $next($request);
    }
}
