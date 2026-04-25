<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Passager;
use App\Models\Trajet;
use App\Models\Paiement;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'passager_id',
        'trajet_id',
        'date_reservation',
        'nombre_places',
        'statut',
        'prix_total'
    ];

    // relations
    public function passager()
    {
        return $this->belongsTo(Passager::class, 'passager_id');
    }

    public function trajet()
    {
        return $this->belongsTo(Trajet::class, 'trajet_id');
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    public function estConfirmee()
    {
        return $this->statut === 'confirmee';
    }

    public function estAnnulee()
    {
        return $this->statut === 'annulee';
    }
}
