<?php 

namespace App\Traits;

trait ApiResponse
{
    public function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    public function error($data, $message = null, $code = 400)
    {
        return response()->json([
            'success' => false,
            'data' => $data,
            'message' => $message,
        ], $code);
    }
}