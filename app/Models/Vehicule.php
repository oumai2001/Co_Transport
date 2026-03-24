<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $fillable = [
        'immatriculation',
        'marque',
        'modele',
        'annee',
        'couleur',
        'capacite',
        'statut',
        'conducteur_id'
    ];
    
    // Relation avec Conducteur
    public function conducteur()
    {
        return $this->belongsTo(Conducteur::class);
    }
    
    // Relation avec Trajets
    public function trajets()
    {
        return $this->hasMany(Trajet::class);
    }
    
    // Vérifier si le véhicule est disponible
    public function estDisponible()
    {
        return $this->statut === 'disponible';
    }
    
    // Mettre en trajet
    public function mettreEnTrajet()
    {
        $this->statut = 'en trajet';
        $this->save();
    }
    
    // Rendre disponible
    public function rendreDisponible()
    {
        $this->statut = 'disponible';
        $this->save();
    }
}