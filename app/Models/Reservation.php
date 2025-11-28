<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    protected $fillable = [
        'name',
        'service_id',
        'heure',
        'date',
    ];

    public function service():HasOne
    {
        return $this->hasOne(Service::class);
    }
}
