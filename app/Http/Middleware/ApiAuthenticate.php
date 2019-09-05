<?php

namespace App\Http\Middleware;

use App\Exceptions\UnAuthenticatedUser;
use Closure;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws UnAuthenticatedUser
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user()) {
            throw new UnAuthenticatedUser(trans('messages.users.not_authenticated'), -3);
        }

        return $next($request);
    }
}
