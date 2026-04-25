<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Conducteur;
use App\Models\Vehicule;
use App\Models\Ville;
use App\Models\Reservation;

class Trajet extends Model
{
    protected $table = 'trajets';

    protected $fillable = [
        'conducteur_id',
        'vehicule_id',
        'ville_depart_id',
        'ville_arrivee_id',
        'date_depart',
        'date_arrivee',
        'prix',
        'places_disponibles',
        'statut'
    ];

    protected $casts = [
        'date_depart' => 'datetime',
        'date_arrivee' => 'datetime',
    ];

    // relations
    public function conducteur()
    {
        return $this->belongsTo(Conducteur::class, 'conducteur_id');
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    public function villeDepart()
    {
        return $this->belongsTo(Ville::class, 'ville_depart_id');
    }

    public function villeArrivee()
    {
        return $this->belongsTo(Ville::class, 'ville_arrivee_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'trajet_id');
    }
    
    public function estAnnule()
    {
        return $this->statut === 'annule';
    }

    public function estTermine()
    {
        return $this->statut === 'termine';
    }
}