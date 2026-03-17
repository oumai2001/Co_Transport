<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trajet extends Model
{
    protected $table = 'trajets';
    protected $fillable = [
        'conducteur_id', 'vehicule_id', 'villeDepart_id', 'villeArrivee_id',
        'dateDepart', 'dateArrivee', 'prix', 'placesDisponibles', 'status'
    ];
    
    // Attributs conformes au diagramme
    private $id;
    private $dateDepart;
    private $dateArrivee;
    private $prix;
    private $status; // enum: programmé, en cours, terminé, annulé
    private $placesDisponibles;
    
    // Relations
    public function conducteur()
    {
        return $this->belongsTo(Conducteur::class, 'conducteur_id');
    }
    
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
    
    public function villeDepart()
    {
        return $this->belongsTo(Ville::class, 'villeDepart_id');
    }
    
    public function villeArrivee()
    {
        return $this->belongsTo(Ville::class, 'villeArrivee_id');
    }
    
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
    // Méthodes du diagramme
    public static function creerTrajet($data)
    {
        $trajet = new self();
        $trajet->fill($data);
        $trajet->save();
        return [$trajet];
    }
    
    public function modifierTrajet($data)
    {
        $this->update($data);
        return true;
    }
    
    public function annulerTrajet()
    {
        $this->status = 'annulé';
        $this->save();
        
        // Annuler toutes les réservations associées
        foreach($this->reservations as $reservation) {
            if($reservation->statut === 'confirmée') {
                $reservation->annulerReservation();
            }
        }
        
        return true;
    }
}