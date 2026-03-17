<?php
namespace App\Models;

class Conducteur extends Utilisateur
{
    protected $table = 'conducteurs';
    
    // Attributs privés (- dans le diagramme)
    private $numeroPermis;
    private $noteMoyenne;
    
    // Getters/Setters
    public function getNumeroPermis()
    {
        return $this->numeroPermis;
    }
    
    public function setNumeroPermis($numeroPermis)
    {
        $this->numeroPermis = $numeroPermis;
    }
    
    public function getNoteMoyenne()
    {
        return $this->noteMoyenne;
    }
    
    public function proposerTrajet($data)
    {
        $trajet = new Trajet();
        $trajet->conducteur_id = $this->id;
        $trajet->vehicule_id = $data['vehicule_id'];
        $trajet->villeDepart_id = $data['villeDepart_id'];
        $trajet->villeArrivee_id = $data['villeArrivee_id'];
        $trajet->dateDepart = $data['dateDepart'];
        $trajet->dateArrivee = $data['dateArrivee'];
        $trajet->prix = $data['prix'];
        $trajet->placesDisponibles = $data['placesDisponibles'];
        $trajet->status = 'programmé';
        $trajet->save();
        
        return $trajet;
    }
    
    public function consulterMesTrajets()
    {
        return Trajet::where('conducteur_id', $this->id)->get();
    }
    
    public function mettreAJourStatut($trajetId, $nouveauStatut)
    {
        $trajet = Trajet::find($trajetId);
        $trajet->status = $nouveauStatut;
        return $trajet->save();
    }
    
    public function voirPassagers($trajetId)
    {
        $trajet = Trajet::find($trajetId);
        return $trajet->reservations()
                      ->where('statut', 'confirmée')
                      ->with('passager')
                      ->get();
    }
}