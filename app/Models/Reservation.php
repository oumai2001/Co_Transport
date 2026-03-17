<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
    protected $fillable = [
        'passager_id', 'trajet_id', 'dateReservation', 
        'nombrePlaces', 'statut', 'prixTotal'
    ];
    
    // Attributs
    private $id;
    private $dateReservation;
    private $nombrePlaces;
    private $statut; // enum: confirmée, en attente, annulée
    private $prixTotal;
    
    // Relations
    public function passager()
    {
        return $this->belongsTo(Passager::class, 'passager_id');
    }
    
    public function trajet()
    {
        return $this->belongsTo(Trajet::class);
    }
    
    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
    
    // Méthodes du diagramme
    public function confirmerReservation()
    {
        if($this->trajet->placesDisponibles >= $this->nombrePlaces) {
            $this->statut = 'confirmée';
            $this->save();
            
            // Réduire les places disponibles
            $this->trajet->placesDisponibles -= $this->nombrePlaces;
            $this->trajet->save();
            
            // Créer le paiement associé
            $paiement = new Paiement();
            $paiement->reservation_id = $this->id;
            $paiement->montant = $this->prixTotal;
            $paiement->datePaiement = date('Y-m-d H:i:s');
            $paiement->statut = 'en attente';
            $paiement->save();
            
            return true;
        }
        return false;
    }
    
    public function annulerReservation()
    {
        if($this->statut === 'confirmée') {
            // Remettre les places disponibles
            $this->trajet->placesDisponibles += $this->nombrePlaces;
            $this->trajet->save();
        }
        
        $this->statut = 'annulée';
        $this->save();
        
        // Rembourser si paiement effectué
        if($this->paiement && $this->paiement->statut === 'payé') {
            $this->paiement->rembourser();
        }
        
        return true;
    }
}