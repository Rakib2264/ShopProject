<?php

namespace App\Helpers;
use Illuminate\Http\JsonResponse; 
class ResponseHelper
{
    public static function Out($message, $data, $code) : JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}