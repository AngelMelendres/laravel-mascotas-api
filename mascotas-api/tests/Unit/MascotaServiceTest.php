<?php

namespace Tests\Unit;

use App\Services\MascotaService;
use Tests\TestCase;

class MascotaServiceTest extends TestCase
{
    public function test_obtiene_datos_de_raza_perro()
    {
        $service = new MascotaService();
        $result = $service->obtenerDatosMascota('perro', 'Labrador');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('imagen_url', $result);
        $this->assertArrayHasKey('descripcion_raza', $result);
    }
}
