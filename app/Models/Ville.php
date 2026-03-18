<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    protected $table = 'villes';
    protected $fillable = ['nom', 'codePostal', 'pays'];
    
    // Attributs
    private $id;
    private $nom;
    private $codePostal;
    private $pays;
    
    // Relations
    public function trajetsDepart()
    {
        return $this->hasMany(Trajet::class, 'villeDepart_id');
    }
    
    public function trajetsArrivee()
    {
        return $this->hasMany(Trajet::class, 'villeArrivee_id');
    }
}