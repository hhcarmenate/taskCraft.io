<?php

namespace App\Http\Traits;

use Exception;
use Illuminate\Http\JsonResponse;

trait FailResponseTrait
{
    public function genericFailResponse(Exception $e): JsonResponse
    {
        return response()->json([
            'message' => $e->getMessage(),
            'data' => []
        ], 500);
    }
}
