<?php

namespace App\Http\Traits;

trait SuccessAndFailedResponseTrait
{
    public function successResponse($statusCode, $successType, $message, $data)
    {
        return response()->json([
            'statusCode'    => $statusCode,
            'success'       => $successType,
            'message'       => $message,
            'data'          => $data
        ], $statusCode);
    }

    public function failedResponse($statusCode, $successType, $message, $data = null)
    {
        return response()->json([
            'statusCode'    => $statusCode,
            'success'       => $successType,
            'message'       => $message,
            'data'          => $data
        ], $statusCode);
    }
}
