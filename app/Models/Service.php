<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function abonnements(): HasMany
    {
        return $this->hasMany(Abonnement::class, 'abonnements');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users');
    }

    public function pivot_A_S():HasMany
    {
        return $this->hasMany(Pivot_A_S::class, 'service_id');
    }

}
