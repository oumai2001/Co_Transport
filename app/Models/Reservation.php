<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'date_reservation',
        'nombre_places',
        'prix_unitaire',
        'prix_total',
        'statut',
        'commentaire',
        'passager_id',
        'trajet_id'
    ];
    
    protected $casts = [
        'date_reservation' => 'datetime',
        'prix_unitaire' => 'float',
        'prix_total' => 'float',
    ];
    
    // Relation avec Passager
    public function passager()
    {
        return $this->belongsTo(Passager::class);
    }
    
    // Relation avec Trajet
    public function trajet()
    {
        return $this->belongsTo(Trajet::class);
    }
    
    // Relation avec Paiement
    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
    
    // Vérifier si la réservation est confirmée
    public function estConfirmee()
    {
        return $this->statut === 'confirmée';
    }
    
    // Confirmer la réservation
    public function confirmer()
    {
        $this->statut = 'confirmée';
        $this->save();
    }
    
    // Annuler la réservation
    public function annuler()
    {
        if ($this->estConfirmee()) {
            // Libérer les places
            $this->trajet->annulerPlaces($this->nombre_places);
        }
        
        $this->statut = 'annulée';
        $this->save();
    }
    
    // Calculer le prix total
    public function calculerPrixTotal()
    {
        $this->prix_total = $this->nombre_places * $this->prix_unitaire;
        $this->save();
        
        return $this->prix_total;
    }
}