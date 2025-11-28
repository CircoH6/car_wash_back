<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class abonne extends Model
{
    protected $fillable = [
        'user_id',
        'abonnement_id',
    ];

    public function users():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function abonnements():HasOne
    {
        return $this->hasOne(Abonnement::class);
    }

}
