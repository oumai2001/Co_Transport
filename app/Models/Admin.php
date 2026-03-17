<?php
namespace App\Models;

class Admin extends Utilisateur
{
    protected $table = 'admins';
    
    // Attribut privé
    private $niveauAcces;
    
    public function getNiveauAcces()
    {
        return $this->niveauAcces;
    }
    
    public function setNiveauAcces($niveau)
    {
        $this->niveauAcces = $niveau;
    }
    
    public function gererUtilisateurs()
    {
        return true;
    }
    
    public function gererVehicules()
    {
        return true;
    }
    
    public function gererTrajets()
    {
        return true;
    }
    
    public function gererReservations()
    {
        return true;
    }
    
    public function consulterStatistiques()
    {
        return true;
    }
}