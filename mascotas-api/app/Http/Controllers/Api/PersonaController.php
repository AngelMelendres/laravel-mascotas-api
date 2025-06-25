<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Persona::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $persona = Persona::create($request->all());
        return response()->json($persona, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $persona = Persona::with('mascotas')->findOrFail($id);
        return response()->json($persona);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $persona = Persona::findOrFail($id);
        $persona->update($request->all());
        return response()->json($persona);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();
        return response()->json(null, 204);
    }
}
