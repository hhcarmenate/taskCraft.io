<?php

namespace App\Http\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait FailResponseTrait
{
    public function genericFailResponse(Exception $e): JsonResponse
    {
        Log::error('Error Trace', [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'message' => $e->getMessage()
        ]);

        return response()->json([
            'message' => $e->getMessage(),
            'data' => []
        ], 500);
    }
}
