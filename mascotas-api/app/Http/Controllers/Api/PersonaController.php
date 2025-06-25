<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Http\Resources\PersonaResource;
use App\Models\Persona;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Personas",
 *     description="Endpoints para gestionar personas"
 * )
 */
class PersonaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/personas",
     *     tags={"Personas"},
     *     summary="Listar personas paginadas",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Listado de personas")
     * )
     */
    public function index()
    {
        return PersonaResource::collection(
            Persona::paginate(10)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/personas",
     *     tags={"Personas"},
     *     summary="Crear nueva persona",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre","email","fecha_nacimiento"},
     *             @OA\Property(property="nombre", type="string", example="Ana Pérez"),
     *             @OA\Property(property="email", type="string", example="ana@example.com"),
     *             @OA\Property(property="fecha_nacimiento", type="string", format="date", example="1990-01-01")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Persona creada exitosamente"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(StorePersonaRequest $request)
    {
        $persona = Persona::create($request->validated());
        return (new PersonaResource($persona))->response()->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *     path="/api/personas/{id}",
     *     tags={"Personas"},
     *     summary="Obtener detalles de una persona",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la persona",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Persona encontrada"),
     *     @OA\Response(response=404, description="Persona no encontrada")
     * )
     */
    public function show($id)
    {
        $persona = Persona::findOrFail($id);
        return new PersonaResource($persona);
    }

    /**
     * @OA\Put(
     *     path="/api/personas/{id}",
     *     tags={"Personas"},
     *     summary="Actualizar una persona",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la persona a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Ana María"),
     *             @OA\Property(property="email", type="string", example="ana.m@example.com"),
     *             @OA\Property(property="fecha_nacimiento", type="string", example="1991-02-15")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Persona actualizada"),
     *     @OA\Response(response=404, description="Persona no encontrada")
     * )
     */
    public function update(UpdatePersonaRequest $request, $id)
    {
        $persona = Persona::findOrFail($id);
        $persona->update($request->validated());
        return new PersonaResource($persona);
    }

    /**
     * @OA\Delete(
     *     path="/api/personas/{id}",
     *     tags={"Personas"},
     *     summary="Eliminar una persona",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Persona eliminada correctamente"),
     *     @OA\Response(response=404, description="Persona no encontrada")
     * )
     */
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();
        return response()->json(['message' => 'Persona eliminada correctamente.'], 204);
    }

    /**
     * @OA\Get(
     *     path="/api/personas/{id}/mascotas",
     *     tags={"Personas"},
     *     summary="Obtener persona con sus mascotas",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la persona",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Persona con mascotas"),
     *     @OA\Response(response=404, description="Persona no encontrada")
     * )
     */
    public function conMascotas($id)
    {
        $persona = Persona::with('mascotas')->findOrFail($id);
        return response()->json($persona);
    }
}
