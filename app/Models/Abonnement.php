<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\HasFactory;

class Abonnement extends Model
{

    protected $fillable = [
        'user_id',
        'service_id',
        'nom',
        'description',
        'prix',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function reservations()
    {
        return $this->hasManyThrough(Reservation::class, Service::class);
    }
}
