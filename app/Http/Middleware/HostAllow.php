<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class HostAllow
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedHosts = [
            'avansdoorstroomproject.loc'
        ];

        if (!in_array($request->getHost(), $allowedHosts)) {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }
}
