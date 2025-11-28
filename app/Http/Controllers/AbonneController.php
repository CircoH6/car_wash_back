<?php

namespace App\Http\Controllers;

use App\Models\abonne;
use App\Models\Abonnement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbonneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abonnes = Abonne::with(['user', 'abonnement'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Liste des abonnes récupérée avec succès.',
            'data' => $abonnes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'abonnement_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Echec',
                'message' => 'Données de Abonne invalides.',
                'errors' => $validator->errors(),
            ], 400);
        }
        $Abonne = Abonne::create([
            'user_id' => $request->user_id,
            'abonnement_id' => $request->abonnement_id,
        ]);

        return response()->json([
            'status' => 'succès',
            'message' => 'Abonne créé avec succès.',
            'data' => $Abonne,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $Abonne = Abonne::with(['user', 'abonnement'])->find($id);

        if ($Abonne) {
            return response()->json([
                'data'=>$Abonne,
                'status'=>'success',
                'message'=>'Détails du Abonne récupéré avec succès',
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
            'user_id' => 'required|integer',
            'abonnement_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Echec',
                'message' => 'Données de Abonne invalides.',
                'errors' => $validator->errors(),
            ], 400);
        }
        $Abonne = Abonne::with(['user', 'abonnement'])->find($id);

        $Abonne = $Abonne->update([
            'user_id' => $request->user_id,
            'abonnement_id' => $request->abonnement_id,
        ]);

        return response()->json([
            'status' => 'succès',
            'message' => 'Abonne mis à jour avec succès.',
            'data' => $Abonne,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Abonne = Abonne::find($id);


        if ($Abonne->delete()) {
            return response()->json(['message' => 'Abonne supprimée avec succès.'], 200);
        }
    }
}
