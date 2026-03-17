<?php
namespace App\Models;

class Passager extends Utilisateur
{
    protected $table = 'passagers';
    
    // Attribut privé (- dans le diagramme)
    private $pointsFidelite;
    
    public function __construct()
    {
        $this->pointsFidelite = 0;
    }
    
    public function getPointsFidelite()
    {
        return $this->pointsFidelite;
    }
    
    public function setPointsFidelite($points)
    {
        $this->pointsFidelite = $points;
    }
    
    public function reserverPlace($trajetId, $nombrePlaces)
    {
        $reservation = new Reservation();
        $reservation->passager_id = $this->id;
        $reservation->trajet_id = $trajetId;
        $reservation->nombrePlaces = $nombrePlaces;
        $reservation->dateReservation = date('Y-m-d H:i:s');
        $reservation->statut = 'en attente';
        $reservation->prixTotal = $nombrePlaces * Trajet::find($trajetId)->prix;
        $reservation->save();
        
        return $reservation;
    }
    
    public function annulerReservation($reservationId)
    {
        $reservation = Reservation::find($reservationId);
        return $reservation->annulerReservation();
    }
    
    public function consulterHistorique()
    {
        return Reservation::where('passager_id', $this->id)
                         ->orderBy('dateReservation', 'desc')
                         ->get();
    }
    
    public function noterConducteur($conducteurId, $note)
    {
        $conducteur = Conducteur::find($conducteurId);
        // Logique de notation
        return true;
    }
    
    public function ajouterAuxFavoris($conducteurId)
    {
        $favori = new Favori();
        $favori->passager_id = $this->id;
        $favori->conducteur_id = $conducteurId;
        $favori->dateAjout = date('Y-m-d H:i:s');
        return $favori->save();
    }
}