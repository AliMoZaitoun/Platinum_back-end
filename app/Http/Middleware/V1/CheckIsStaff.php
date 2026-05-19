<?php

namespace App\Http\Middleware\V1;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CheckIsStaff
{
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->user() && in_array($request->user()->type, ['admin', 'employee'])) {
            return $next($request);
        }

        return throw new AccessDeniedHttpException();
    }
}
