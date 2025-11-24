<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();

        if ($services) {
            return response()->json([
                'data' => $services,
                'status' => 'success',
                'message' => 'Liste des services récupérée avec succès.',
            ]);
        }
         return response()->json([

                'status' => 'Echec',
                'message' => 'Aucun service trouvé.',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $service = Service::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
        ]);

        return response()->json([
            'status' => 'succès',
            'message' => 'Service créé avec succès.',
            'data' => $service,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($id);

        $service = $service->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
        ]);

        return response()->json([
            'status' => 'succès',
            'message' => 'service mis à jour avec succès.',
            'data' => $service,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);


        $service->delete();

        return response()->json(['message' => 'service supprimée avec succès.']);
    }
}
