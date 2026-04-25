<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Conducteur;
use App\Models\Trajet;

class Vehicule extends Model
{
    protected $table = 'vehicules';

    protected $fillable = [
        'immatriculation',
        'modele',
        'marque',
        'capacite',
        'statut',
        'conducteur_id'
    ];

    // relations
    public function conducteur()
    {
        return $this->belongsTo(Conducteur::class, 'conducteur_id');
    }

    public function trajets()
    {
        return $this->hasMany(Trajet::class, 'vehicule_id');
    }
    
    public function estDisponible()
    {
        return $this->statut === 'disponible';
    }

    public function enMaintenance()
    {
        return $this->statut === 'maintenance';
    }
}