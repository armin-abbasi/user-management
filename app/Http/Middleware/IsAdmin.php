<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        if (! $request->user()->authorizeRoles('admin')) {
            return response([
                'responseCode' => -3,
                'responseMessage' => 'You must be an admin to continue.',
                'data' => null,
            ], 403);
        }

        return $next($request);
    }
}
