<?php

namespace App\Http\Middleware\V1;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CheckIsClient
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->type === 'client') {
            return $next($request);
        }

        return throw new AccessDeniedHttpException();
    }
}
