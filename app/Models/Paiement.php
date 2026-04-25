<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;

class Paiement extends Model
{
    protected $table = 'paiements';

    protected $fillable = [
        'reservation_id',
        'montant',
        'date_paiement',
        'mode_paiement',
        'statut'
    ];

    protected $casts = [
        'date_paiement' => 'datetime'
    ];

    // relation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function marquerCommePaye()
    {
        $this->statut = 'paye';
        return $this->save();
    }

    public function rembourser()
    {
        $this->statut = 'rembourse';
        return $this->save();
    }

    public function estPaye()
    {
        return $this->statut === 'paye';
    }
}