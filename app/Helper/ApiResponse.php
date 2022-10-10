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
        return response()->json([
            'isSuccess'=> false,
            'errors' => $error,
            'message'=> 'Error occured'
        ], $code);
    }
}