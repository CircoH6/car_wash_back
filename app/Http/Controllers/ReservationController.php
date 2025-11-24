<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
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
        $reservations = Reservation::with(['user', 'service'])->get();

        return response()->json([
            'data' => $reservations,
            'status' => 'success',
            'message' => 'Liste des réservations récupérée avec succès.',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|',
            'service_id' => 'required|integer',
            'heure' => 'required|time|',
            'date' => 'required|date|',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Echec',
                'message' => 'Données de réservation invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'heure' => $request->heure,
            'date' => $request->date,
        ]);

        return response()->json([
            'status' => 'succès',
            'message' => 'reservation créé avec succès.',
            'data' => $reservation,
        ], 201);
    }

     /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::with(['user', 'service'])->findOrFail($id);
        return response()->json([
            'data' => $reservation,
            'status' => 'success',
            'message' => 'Détails de la réservation récupérés avec succès.',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
        $reservation = Reservation::findOrFail($id);

        $reservation->delete();

        return response()->json(['message' => 'reservation supprimée avec succès.']);
    }
}
