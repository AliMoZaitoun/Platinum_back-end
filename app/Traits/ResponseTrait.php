<?php

namespace App\Traits;

trait ResponseTrait
{
    public function successResponse($data, $message = "Request was successful", $code = 200)
    {
        return response()->json([
            'status'  => __('messages.common.success'),
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    public function errorResponse($message = "An error occurred", $code = 400, $errors = [])
    {
        return response()->json([
            'status'  => __('messages.common.error'),
            'message' => $message,
            'errors'  => $errors
        ], $code);
    }

    public function successCollection($collection, $resourceClass, $messageKey)
    {
        return $this->successResponse(
            $resourceClass::collection($collection),
            $collection->isEmpty() ? __('messages.common.empty') : __($messageKey)
        );
    }
}
