<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExceptionJsonResponse extends Exception
{
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        $previous = $this->getPrevious();
        $statusHttp = $this->getCode() ?: 500; // Se não tiver código, assume 500
        $responseError = [
            'message' => $this->getMessage(),
        ];

        if (env('APP_DEBUG')) {
            $responseError = array_merge($responseError, [
                'exception' => $previous ? $previous->getMessage() : 'N/A',
                'error' => $previous ? $previous : 'N/A',
                'trace' => $previous ? $previous->getTrace() : 'N/A',
            ]);
        }

        return response()->json($responseError, $statusHttp);
    }
}

