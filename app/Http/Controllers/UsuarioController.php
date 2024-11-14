<?php

namespace App\Http\Controllers;

use App\Models\Trabajadores;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $sol = Usuario::where('rol', 'trabajador')->get();
        return response()->json($sol);

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
            'firebaseUID' => $request->firebaseUID,
            'nombreCompleto' => $request->nombreCompleto,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'ubicacion' => $request->ubicacion,
            'rol' => $request->rol,
            'fechaRegistro' => $request->fechaRegistro, // Convertir la fecha a UTCDateTime
            'favoritos' => $request->favoritos, // Asumimos que es un array de IDs
        ];

        $ee = Usuario::create($documento);

         return response()->json(['message' => 'Documento insertado con éxito', 'data' => $ee]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $sol = Usuario::where('firebaseUID', $id)->first(); 
            if ($sol) {
                return response()->json($sol); 
            } else {
                return response()->json(['error' => 'usuario no encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'usuario no encontrado'], 404);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
