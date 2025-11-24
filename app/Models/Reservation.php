<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'heure',
        'date',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
