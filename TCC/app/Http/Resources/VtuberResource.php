<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class VtuberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return[
        'id' => $this->id,
        'nome' => $this->nome,
        'descricao' => $this->descricao,
        'empresa_id' => EmpresaResource::make($this->whenLoaded('empresa_id')),
        'imagem' => $this->when($this->imagem, env('APP_URL').Storage::url('vtubers/' . $this->imagem))
        ];
    }
}
