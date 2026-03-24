<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    protected $fillable = [
        'nom',
        'code_postal',
        'pays',
        'latitude',
        'longitude'
    ];
    
    // Relation avec Trajets (départ)
    public function trajetsDepart()
    {
        return $this->hasMany(Trajet::class, 'ville_depart_id');
    }
    
    // Relation avec Trajets (arrivée)
    public function trajetsArrivee()
    {
        return $this->hasMany(Trajet::class, 'ville_arrivee_id');
    }
    
    // Tous les trajets liés à cette ville
    public function trajets()
    {
        return Trajet::where('ville_depart_id', $this->id)
                    ->orWhere('ville_arrivee_id', $this->id);
    }
}