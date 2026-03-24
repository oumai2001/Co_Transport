<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conducteur extends Model
{
    protected $fillable = [
        'numero_permis',
        'date_permis',
        'verification',
        'note_moyenne',
        'utilisateur_id'
    ];
    
    protected $casts = [
        'date_permis' => 'date',
        'verification' => 'boolean',
        'note_moyenne' => 'float',
    ];
    
    // Relation avec Utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
    
    // Relation avec Véhicules
    public function vehicules()
    {
        return $this->hasMany(Vehicule::class);
    }
    
    // Relation avec Trajets
    public function trajets()
    {
        return $this->hasMany(Trajet::class);
    }
    
    // Récupérer le véhicule principal
    public function vehiculePrincipal()
    {
        return $this->vehicules()->first();
    }
    
    // Vérifier si le conducteur est vérifié
    public function estVerifie()
    {
        return $this->verification;
    }
    
    // Calculer la note moyenne
    public function calculerNoteMoyenne()
    {
        $notes = $this->hasMany(Avis::class, 'cible_id')->where('type_cible', 'conducteur')->pluck('note');
        $this->note_moyenne = $notes->avg();
        $this->save();
        
        return $this->note_moyenne;
    }
}