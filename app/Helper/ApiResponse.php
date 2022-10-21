<?php
namespace App\Helper;

trait ApiResponse{
    protected function successResponse($data, $message, $code)
    {
        return response()->json([
            'isSuccess'=> true,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    protected function errorResponse($error, $code)
    {

        //* Configure sentry for capture error message
        \Sentry\captureMessage($error);

        return response()->json([
            'isSuccess'=> false,
            'errors' => $error,
            'message'=> 'Error occured'
        ], $code);
    }
    protected function loginSuccessResponse($token, $message, $code, $expiryTime)
    {
        return response()->json([
            'isSuccess'=> true,
            'message' => $message,
            'token' => $token,
            'expires-in' => $expiryTime
        ], $code);
    }
}
