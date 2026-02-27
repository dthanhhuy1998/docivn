<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnlyMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('system.admin_only_mode')) {
            if (!in_array($request->path(), config('system.allowed_routes')) && !$request->is('admin/*') && !$request->is('admin')) {
                abort(403, __('No access'));
            }
        }

        return $next($request);
    }
}
