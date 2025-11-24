<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'prix',
    ];

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'reservations');
    }

    public function abonnements(): BelongsToMany
    {
        return $this->belongsToMany(Abonnement::class, 'abonnements');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users');
    }
}
