<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMascotaRequest;
use App\Http\Requests\UpdateMascotaRequest;
use App\Http\Resources\MascotaResource;
use App\Models\Mascota;
use App\Services\MascotaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Mascotas",
 *     description="Endpoints para gestión de mascotas"
 * )
 */
class MascotaController extends Controller
{
    public function __construct(private MascotaService $mascotaService) {}

    /**
     * @OA\Get(
     *     path="/api/mascotas",
     *     tags={"Mascotas"},
     *     summary="Listar mascotas paginadas",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Listado de mascotas")
     * )
     */
    public function index()
    {
        return MascotaResource::collection(
            Mascota::with('persona')->paginate(10)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/mascotas",
     *     tags={"Mascotas"},
     *     summary="Crear una nueva mascota",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre","especie","raza","edad","persona_id"},
     *             @OA\Property(property="nombre", type="string", example="Toby"),
     *             @OA\Property(property="especie", type="string", example="perro"),
     *             @OA\Property(property="raza", type="string", example="Labrador"),
     *             @OA\Property(property="edad", type="integer", example=4),
     *             @OA\Property(property="persona_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Mascota creada"),
     *     @OA\Response(response=422, description="Validación fallida")
     * )
     */
    public function store(StoreMascotaRequest $request)
    {
        $data = $request->validated();

        $extras = $this->mascotaService->obtenerDatosMascota(
            $data['especie'],
            $data['raza']
        );

        $mascota = Mascota::create([
            ...$data,
            'imagen_url' => $extras['imagen_url'] ?? null,
            'descripcion_raza' => $extras['descripcion_raza'] ?? null,
        ]);

        return (new MascotaResource($mascota))->response()->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *     path="/api/mascotas/{id}",
     *     tags={"Mascotas"},
     *     summary="Obtener una mascota por ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la mascota",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Datos de la mascota"),
     *     @OA\Response(response=404, description="Mascota no encontrada")
     * )
     */
    public function show($id)
    {
        $mascota = Mascota::with('persona')->findOrFail($id);
        return new MascotaResource($mascota);
    }

    /**
     * @OA\Put(
     *     path="/api/mascotas/{id}",
     *     tags={"Mascotas"},
     *     summary="Actualizar mascota",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la mascota a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Toby"),
     *             @OA\Property(property="edad", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Mascota actualizada"),
     *     @OA\Response(response=404, description="Mascota no encontrada")
     * )
     */
    public function update(UpdateMascotaRequest $request, $id)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->update($request->validated());

        return new MascotaResource($mascota);
    }

    /**
     * @OA\Delete(
     *     path="/api/mascotas/{id}",
     *     tags={"Mascotas"},
     *     summary="Eliminar mascota",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la mascota",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Mascota eliminada")
     * )
     */
    public function destroy($id)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->delete();

        return response()->json(['message' => 'Mascota eliminada correctamente.'], 204);
    }

    /**
     * @OA\Get(
     *     path="/api/razas",
     *     tags={"Mascotas"},
     *     summary="Obtener razas desde API externa",
     *     @OA\Parameter(
     *         name="especie",
     *         in="query",
     *         required=true,
     *         description="perro o gato",
     *         @OA\Schema(type="string", enum={"perro", "gato"})
     *     ),
     *     @OA\Response(response=200, description="Lista de razas"),
     *     @OA\Response(response=422, description="Parámetro inválido")
     * )
     */
    public function getRazas(Request $request)
    {
        $especie = strtolower($request->query('especie'));

        if (!in_array($especie, ['perro', 'gato'])) {
            return response()->json([
                'error' => 'Parámetro "especie" inválido. Solo se permite "perro" o "gato".'
            ], 422);
        }

        $apiUrl = $especie === 'perro'
            ? 'https://api.thedogapi.com/v1/breeds'
            : 'https://api.thecatapi.com/v1/breeds';

        $response = Http::get($apiUrl);

        if (!$response->ok()) {
            return response()->json(['error' => 'No se pudo obtener las razas.'], 500);
        }

        $razas = collect($response->json())->pluck('name');

        return response()->json([
            'especie' => $especie,
            'razas' => $razas
        ]);
    }
}
