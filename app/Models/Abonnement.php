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
        'nom',
        'description',
        'prix',
    ];


    public function pivot_A_S():HasMany
    {
        return $this->hasMany(Pivot_A_S::class, 'abonnement_id');
    }

    public function service():BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'pivot__a__s', 'abonnement_id', 'service_id');
    }
}
