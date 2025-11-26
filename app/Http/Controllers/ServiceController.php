<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Liste des services récupérée avec succès.',
            'data' => $services,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'prix' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Echec',
                'message' => 'Données de service invalides.',
                'errors' => $validator->errors(),
            ], 400);
        }
        $service = Service::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
        ]);

        return response()->json([
            'status' => 'succès',
            'message' => 'Service créé avec succès.',
            'data' => $service,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $service = Service::find($id);

        if ($service) {
            return response()->json([
                'data'=>$service,
                'status'=>'success',
                'message'=>'Détails du service récupéré avec succès',
            ]);
        }

        return response()->json([
            'status'=>'échec',
            'message'=>'action invalide',
        ], 400);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'prix' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Echec',
                'message' => 'Données de service invalides.',
                'errors' => $validator->errors(),
            ], 400);
        }
        $service = Service::find($id);

        $service = $service->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
        ]);

        return response()->json([
            'status' => 'succès',
            'message' => 'service mis à jour avec succès.',
            'data' => $service,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);


        if ($service->delete()) {
            return response()->json(['message' => 'service supprimée avec succès.'], 200);
        }
    }
}
