<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'montant',
        'date_paiement',
        'mode_paiement',
        'statut',
        'transaction_id',
        'reservation_id'
    ];
    
    protected $casts = [
        'date_paiement' => 'datetime',
        'montant' => 'float',
    ];
    
    // Relation avec Réservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
    
    // Vérifier si le paiement est validé
    public function estPaye()
    {
        return $this->statut === 'payé';
    }
    
    // Valider le paiement
    public function valider()
    {
        $this->statut = 'payé';
        $this->save();
        
        // Confirmer la réservation
        $this->reservation->confirmer();
    }
    
    // Rembourser
    public function rembourser()
    {
        $this->statut = 'remboursé';
        $this->save();
    }
    
    // Générer une facture (simulation)
    public function genererFacture()
    {
        return [
            'numero' => 'INV-' . str_pad($this->id, 6, '0', STR_PAD_LEFT),
            'date' => $this->date_paiement,
            'montant' => $this->montant,
            'mode' => $this->mode_paiement,
            'reservation_id' => $this->reservation_id,
        ];
    }
}