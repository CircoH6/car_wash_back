<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use Illuminate\Http\Request;


class PivotASController extends Controller
{
    public function attach(Request $request)
    {
        $request->validate([
            'abonnement_id' => 'required|exists:abonnements,id',
            'service_id' => 'required|array',
            'service_id.*' => 'exists:services,id',
        ]);

        $abonnement = Abonnement::find($request->abonnement_id);

        $abonnement->services()->attach($request->service_id);

        return response()->json([
            'message' => 'Services attachés avec succès.',
            'data' => $abonnement->load('services')
        ], 200);
    }
}
