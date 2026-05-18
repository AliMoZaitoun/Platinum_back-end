<?php

namespace App\Traits;

trait ResponseTrait
{
    use ProvidesUserResource;
    public function successResponse($data, $message = null, $code = 200)
    {
        return response()->json([
            'status'  => __('messages.common.success'),
            'message' => $message ?? __('messages.common.success'),
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

    public function successUserCollection($collection, $messageKey = "messages.common.success")
    {
        $data = [];
        foreach ($collection as $item) {
            $data[] = $this->resolveUserResource($item->user);
        }
        return $this->successResponse(
            $data,
            $collection->isEmpty() ? __('messages.system.no_results') : __($messageKey)
        );
    }

    public function successCollection($collection, $resourceClass, $messageKey = "messages.common.success", $code = 200)
    {
        return $this->successResponse(
            $resourceClass::collection($collection),
            $collection->isEmpty() ? __('messages.system.no_results') : __($messageKey),
            $code
        );
    }

    public function useResource($item, $resourceClass, $messageKey = "messages.common.success", $code = 200)
    {
        return $this->successResponse(
            new $resourceClass($item),
            __($messageKey),
            $code
        );
    }
}
