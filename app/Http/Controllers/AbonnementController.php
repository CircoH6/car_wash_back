<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Abonnement;

class AbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abonnements = Abonnement::all();

        if ($abonnements) {
            return response()->json([
                'data' => $abonnements,
                'status' => 'success',
                'message' => 'Liste des abonnements récupérée avec succès.',
            ]);
        }
         return response()->json([

                'status' => 'Echec',
                'message' => 'Aucun abonnement trouvé.',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $abonnement = Abonnement::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
        ]);

        return response()->json([
            'status' => 'succès',
            'message' => 'abonnement créé avec succès.',
            'data' => $abonnement,
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
        $abonnement = Abonnement::findOrFail($id);

        $abonnement = $abonnement->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
        ]);

        return response()->json([
            'status' => 'succès',
            'message' => 'abonnement mis à jour avec succès.',
            'data' => $abonnement,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $abonnement = abonnement::find($id);


        $abonnement->delete();

        return response()->json(['message' => 'abonnement supprimée avec succès.']);
    }
}
