<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\pivot_A_S;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class   PivotASController extends Controller
{
    public function index(Request $request)
    {
        $pivotAbonnements = Abonnement::with(['service'])->get();

        if ($pivotAbonnements) {
            return response()->json([
                'data' => $pivotAbonnements,
                'status' => 'success',
                'message' => 'Liste des pivotAbonnements récupérée avec succès.',
            ]);
        }

        return response()->json([
            'status' => 'échec',
            'message' => 'Aucun pivotAbonnement trouvé'
        ]);
    }

    public function attach(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'abonnement_id' => 'required|exists:abonnements,id',
            'service_id' => 'required|array',
            'service_id.*' => 'exists:services,id',
        ]);
       // dd($request->all());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Échec',
                'message' => 'Données de pivotAS invalidées.',
                'errors' => $validator->errors(),
            ], 400);
        }
      //  $abonnement = Abonnement::find($request->abonnement_id)->with('serce_id');
        //dd($request->abonnement_id);
        foreach ($request->service_id as $value) {
            $pivotAbonnement = Pivot_A_S::create([
                'abonnement_id' => $request->abonnement_id,
                'service_id' => $value['service_id'],
            ]);
        }

        return response()->json([
            'message' => 'Services attachés avec succès.',
            'data' => $pivotAbonnement
        ], 200);
    }

    public function show($id)
    {
        $pivotAbonnement = Abonnement::with('service')->find($id);

        if ($pivotAbonnement) {
            return response()->json([
                'data' => $pivotAbonnement,
                'status' => 'success',
                'message' => 'Le pivotAbonnement récupéré avec succès.',
            ]);
        }

        return response()->json([
            'status' => 'échec',
            'message' => 'Aucun pivotAbonnement trouvé avec cet id'
        ]);
    }
}
