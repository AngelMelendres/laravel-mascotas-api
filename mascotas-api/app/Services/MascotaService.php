<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MascotaService
{
    public function obtenerDatosMascota($especie, $raza)
    {
        $apiUrl = match (strtolower($especie)) {
            'perro' => 'https://api.thedogapi.com/v1/breeds/search?q=' . urlencode($raza),
            'gato'  => 'https://api.thecatapi.com/v1/breeds/search?q=' . urlencode($raza),
            default => null,
        };

        if (!$apiUrl) return null;

        $response = Http::get($apiUrl);

        if ($response->ok() && !empty($response[0])) {
            return [
                'descripcion_raza' => $response[0]['temperament'] ?? 'Sin descripción',
                'imagen_url' => $this->obtenerImagenUrl($especie),
            ];
        }

        Log::warning("No se pudo obtener datos de raza para especie: $especie y raza: $raza");
        return null;
    }

    private function obtenerImagenUrl($especie)
    {
        $imgApi = strtolower($especie) === 'perro'
            ? 'https://api.thedogapi.com/v1/images/search'
            : 'https://api.thecatapi.com/v1/images/search';

        $imgResponse = Http::get($imgApi);

        return $imgResponse->ok() && !empty($imgResponse[0]['url'])
            ? $imgResponse[0]['url']
            : null;
    }
}
