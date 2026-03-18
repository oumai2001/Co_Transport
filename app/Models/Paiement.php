<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $table = 'paiements';
    protected $fillable = ['reservation_id', 'montant', 'datePaiement', 'modePaiement', 'statut'];
    
    // Attributs
    private $id;
    private $montant;
    private $datePaiement;
    private $modePaiement; // enum: carte, espéces
    private $statut; // enum: payé, remboursé, en attente
    
    // Relation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
    
    // Méthodes
    public function effectuerPaiement()
    {
        $this->statut = 'payé';
        return $this->save();
    }
    
    public function rembourser()
    {
        $this->statut = 'remboursé';
        return $this->save();
    }
    
    public function verifierPaiement()
    {
        return $this->statut === 'payé';
    }
}