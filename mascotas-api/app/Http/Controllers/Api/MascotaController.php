<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Mascota::with('persona')->paginate(10));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mascota = Mascota::create($request->all());
        return response()->json($mascota, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mascota = Mascota::with('persona')->findOrFail($id);
        return response()->json($mascota);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->update($request->all());
        return response()->json($mascota);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->delete();
        return response()->json(null, 204);
    }
}
