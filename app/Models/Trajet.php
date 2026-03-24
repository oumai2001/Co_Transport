<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trajet extends Model
{
    protected $fillable = [
        'ville_depart_id',
        'ville_arrivee_id',
        'adresse_depart',
        'adresse_arrivee',
        'date_depart',
        'date_arrivee',
        'prix',
        'places_totales',
        'places_disponibles',
        'statut',
        'conducteur_id',
        'vehicule_id'
    ];
    
    protected $casts = [
        'date_depart' => 'datetime',
        'date_arrivee' => 'datetime',
        'prix' => 'float',
    ];
    
    // Relation avec Ville (départ)
    public function villeDepart()
    {
        return $this->belongsTo(Ville::class, 'ville_depart_id');
    }
    
    // Relation avec Ville (arrivée)
    public function villeArrivee()
    {
        return $this->belongsTo(Ville::class, 'ville_arrivee_id');
    }
    
    // Relation avec Conducteur
    public function conducteur()
    {
        return $this->belongsTo(Conducteur::class);
    }
    
    // Relation avec Véhicule
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
    
    // Relation avec Réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
    // Relation avec Favoris
    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }
    
    // Passagers qui ont réservé
    public function passagers()
    {
        return $this->belongsToMany(Passager::class, 'reservations', 'trajet_id', 'passager_id')
                    ->withPivot('nombre_places', 'statut', 'prix_total')
                    ->withTimestamps();
    }
    
    // Vérifier s'il reste des places
    public function restePlaces()
    {
        return $this->places_disponibles > 0;
    }
    
    // Réserver des places
    public function reserverPlaces($nombre)
    {
        if ($this->places_disponibles >= $nombre) {
            $this->places_disponibles -= $nombre;
            $this->save();
            return true;
        }
        return false;
    }
    
    // Annuler des places
    public function annulerPlaces($nombre)
    {
        $this->places_disponibles += $nombre;
        $this->save();
    }
    
    // Démarrer le trajet
    public function demarrer()
    {
        $this->statut = 'en cours';
        $this->save();
        
        if ($this->vehicule) {
            $this->vehicule->mettreEnTrajet();
        }
    }
    
    // Terminer le trajet
    public function terminer()
    {
        $this->statut = 'terminé';
        $this->save();
        
        if ($this->vehicule) {
            $this->vehicule->rendreDisponible();
        }
    }
}