<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Abonnement;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

class AbonnementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abonnements = Abonnement::with(['service'])->get();

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
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|array',
            'service_id.*' => 'exists:services,id',
            'nom' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'prix' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Echec',
                'message' => 'Données des abonnements invalides.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $abonnement = Abonnement::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
        ]);

        $abonnement->services()->attach($request->service_id);

        return response()->json([
            'status' => 'succès',
            'message' => 'abonnement créé avec succès.',
            'data' => $abonnement,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $abonnement = Abonnement::with(['service'])->find($id);

        if($abonnement){
            return response()->json([
                'data'=>$abonnement,
                'status'=> 'succès',
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|array',
            'service_id.*' => 'exists:services,id',
            'nom' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'prix' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Echec',
                'message' => 'Données des abonnements invalides.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $abonnement = Abonnement::find($id);

        $abonnement = $abonnement->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
        ]);

        $abonnement->services()->attach($request->service_id);

        return response()->json([
            'status' => 'succès',
            'message' => 'abonnement mis à jour avec succès.',
            'data' => $abonnement,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $abonnement = abonnement::find($id);


        if($abonnement->delete()){
            return response()->json(['message' => 'abonnement supprimée avec succès.'], 200);
        }

    }
}
