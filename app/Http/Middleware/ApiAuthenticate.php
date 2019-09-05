<?php

namespace App\Http\Middleware;

use App\Exceptions\UnAuthenticatedUserException;
use Closure;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws UnAuthenticatedUserException
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user()) {
            throw new UnAuthenticatedUserException(trans('messages.users.not_authenticated'), -3);
        }

        return $next($request);
    }
}
