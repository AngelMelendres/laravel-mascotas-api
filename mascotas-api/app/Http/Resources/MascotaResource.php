<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MascotaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'especie' => $this->especie,
            'raza' => $this->raza,
            'edad' => $this->edad,
            'imagen_url' => $this->imagen_url,
            'descripcion_raza' => $this->descripcion_raza,
            'persona' => [
                'id' => $this->persona->id,
                'nombre' => $this->persona->nombre,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
