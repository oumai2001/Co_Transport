<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passager extends Model
{
    protected $fillable = [
        'points_fidelite',
        'note_moyenne',
        'preferences',
        'utilisateur_id'
    ];
    
    protected $casts = [
        'points_fidelite' => 'integer',
        'note_moyenne' => 'float',
    ];
    
    // Relation avec Utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
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
    
    // Récupérer les trajets favoris
    public function trajetsFavoris()
    {
        return $this->belongsToMany(Trajet::class, 'favoris', 'passager_id', 'trajet_id')
                    ->withPivot('date_ajout')
                    ->withTimestamps();
    }
    
    // Calculer la note moyenne
    public function calculerNoteMoyenne()
    {
        $avis = $this->hasMany(Avis::class, 'cible_id')->where('type_cible', 'conducteur');
        $this->note_moyenne = $avis->avg('note');
        $this->save();
        
        return $this->note_moyenne;
    }
    
    // Ajouter des points de fidélité
    public function ajouterPoints($points)
    {
        $this->points_fidelite += $points;
        $this->save();
    }
}