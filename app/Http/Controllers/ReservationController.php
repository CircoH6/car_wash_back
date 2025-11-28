<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['service'])->get();

        if ($reservations) {
            return response()->json([
                'data' => $reservations,
                'status' => 'success',
                'message' => 'Liste des réservations récupérée avec succès.',
            ]);
        }

        return response()->json([
            'status' => 'échec',
            'message' => 'Aucune réservation trouvé'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'service_id' => 'required|integer',
            'heure' => 'required|string|',
            'date' => 'required|string|',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Echec',
                'message' => 'Données de réservation invalides.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $reservation = Reservation::create([
            'name' => $request->name,
            'service_id' => $request->service_id,
            'heure' => $request->heure,
            'date' => $request->date,
        ]);

        return response()->json([
            'status' => 'succès',
            'message' => 'reservation créé avec succès.',
            'data' => $reservation,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::with(['service'])->find($id);

        if ($reservation) {
            return response()->json([
                'data' => $reservation,
                'status' => 'success',
                'message' => 'Détails de la réservation récupérés avec succès.',
            ]);
        }

        return response()->json([
            'status' => 'échec',
            'message' => 'Aucune réservation trouvé.',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'service_id' => 'required|integer',
            'heure' => 'required|string|',
            'date' => 'required|date|',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Échec',
                'message' => 'Données de réservation invalidées.',
                'errors' => $validator->errors(),
            ], 400);
        }

        $reservation = Reservation::find($id);

        $reservation = $reservation->update($request->only(([
            'service_id',
            'heure',
            'date',
            'statut',
        ])));

        return response()->json([
            'status' => 'succès',
            'message' => 'reservation mis à jour avec succès.',
            'data' => $reservation,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::find($id);

        if ($reservation->delete()) {
            return response()->json(['message' => 'reservation supprimée avec succès.'], 200);
        }
    }
}
