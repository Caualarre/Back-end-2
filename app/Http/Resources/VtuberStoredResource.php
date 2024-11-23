<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VtuberStoredResource extends VtuberResource
{

    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->setStatusCode(201,'Vtuber Criado!');
    }

    public function with(Request $request): array
    {
        return [
            'message' => 'Vtuber criado com sucesso!!',
        ];
    }
}
