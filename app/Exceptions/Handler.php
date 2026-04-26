<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Spatie\Permission\Exceptions\UnauthorizedException as UnauthorizedExceptionSpatie;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;



class Handler
{
    use ResponseTrait;
    public function register(Exceptions $exceptions): void
    {
        $exceptions->render(function (NotFoundHttpException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        });

        $exceptions->render(function (UnauthorizedException $e) {
            return $this->errorResponse(__('messages.common.unauthorized'), 401);
        });

        $exceptions->render(function (UnauthorizedExceptionSpatie $e) {
            return $this->errorResponse(__('messages.common.unauthorized'), 401);
        });

        $exceptions->render(function (AccessDeniedHttpException $e) {
            return $this->errorResponse(__('messages.common.unauthorized'), 403);
        });

        $exceptions->render(function (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        });

        $exceptions->render(function (NotFoundException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?: 404);
        });

        $exceptions->render(function (InvalidCredentialException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?: 401);
        });

        $exceptions->render(function (OtpCodeExpiredException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?: 403);
        });

        $exceptions->render(function (InvalidArgumentException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?: 403);
        });
        // $exceptions->render(function (Exception $e) {
        //     return $this->errorResponse($e->getMessage(), $e->getCode() ?: 403);
        // });
    }
}
