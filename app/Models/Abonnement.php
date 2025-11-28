<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Abonnement extends Model
{

    protected $fillable = [
        'user_id',
        'service_id',
        'nom',
        'description',
        'prix',
    ];

    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function services():HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function reservations():HasManyThrough
    {
        return $this->hasManyThrough(Reservation::class, Service::class);
    }

    public function pivot_A_S():HasMany
    {
        return $this->hasMany(Pivot_A_S::class, 'abonnement_id');
    }
}
