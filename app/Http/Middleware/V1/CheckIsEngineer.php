<?php

namespace App\Http\Middleware\V1;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CheckIsEngineer
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->type === 'engineer') {
            return $next($request);
        }

        return throw new AccessDeniedHttpException();
    }
}
