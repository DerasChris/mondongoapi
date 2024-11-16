<?php

namespace App\Http\Controllers;
use App\Models\SolicitudesTrabajo;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solicitudes = SolicitudesTrabajo::all();
        return response()->json($solicitudes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function insertarDocumento(Request $request)
    {
        $documento = [
            'usuarioId' => $request->usuarioId,
            'trabajadorId' => $request->trabajadorId,
            'tipoTrabajo' => $request->tipoTrabajo,
            'descripcionProblema' => $request->descripcionProblema,
            'nivelUrgencia' => $request->nivelUrgencia,
            'fotosProblema' => $request->fotosProblema,
            'hora' => $request->hora,
            'fecha' => $request->fecha,
            'presupuesto' => $request->presupuesto,
            'estado' => $request->estado,
        ];

        $solicitud = SolicitudesTrabajo::create($documento);

        return response()->json(['message' => 'Documento insertado con éxito', 'data' => $solicitud]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $sol = SolicitudesTrabajo::where('usuarioId', $id)->get();
        return response()->json($sol);
        } catch (\Exception $e) {
            return response()->json(['error' => 'solicitud no encontrada'], 404);
        }
    }

    public function showTrabajador(string $id)
    {
        try {
            $sol = SolicitudesTrabajo::where('trabajadorId', $id)->get();
        return response()->json($sol);
        } catch (\Exception $e) {
            return response()->json(['error' => 'solicitud no encontrada'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Buscar el documento existente por su ID
    $solicitud = SolicitudesTrabajo::find($id);

    // Verificar si el documento existe
    if (!$solicitud) {
        return response()->json(['message' => 'Documento no encontrado'], 404);
    }

    // Filtrar solo los campos que están presentes en la solicitud
    $dataToUpdate = array_filter([
        'usuarioId' => $request->usuarioId,
        'trabajadorId' => $request->trabajadorId,
        'tipoTrabajo' => $request->tipoTrabajo,
        'descripcionProblema' => $request->descripcionProblema,
        'nivelUrgencia' => $request->nivelUrgencia,
        'fotosProblema' => $request->fotosProblema,
        'hora' => $request->hora,
        'fecha' => $request->fecha,
        'presupuesto' => $request->presupuesto,
        'estado' => $request->estado,
    ], function ($value) {
        return !is_null($value);
    });

    // Actualizar solo los campos proporcionados en el request
    $solicitud->update($dataToUpdate);

    return response()->json(['message' => 'Documento actualizado con éxito', 'data' => $solicitud]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
