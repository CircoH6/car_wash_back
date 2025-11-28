<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pivot_A_S extends Model
{
    protected $fillable = [
        'abonnement_id',
        'service_id',
    ];

    public function services():HasMany
    {
        return $this->hasMany(Service::class, 'id');
    }

    public function abonnements():HasMany
    {
        return $this->hasMany(Abonnement::class, 'abonnement_id');
    }
}
