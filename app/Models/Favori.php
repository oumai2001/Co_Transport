<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    protected $table = 'favoris';
    protected $fillable = ['passager_id', 'conducteur_id', 'dateAjout'];
    
    // Attributs
    private $id;
    private $dateAjout;
    
    // Relations
    public function passager()
    {
        return $this->belongsTo(Passager::class, 'passager_id');
    }
    
    public function conducteur()
    {
        return $this->belongsTo(Conducteur::class, 'conducteur_id');
    }
    
    // Méthodes
    public function ajouterFavori($passagerId, $conducteurId)
    {
        $favori = new self();
        $favori->passager_id = $passagerId;
        $favori->conducteur_id = $conducteurId;
        $favori->dateAjout = date('Y-m-d H:i:s');
        return $favori->save();
    }
    
    public function supprimerFavori($id)
    {
        $favori = self::find($id);
        return $favori->delete();
    }
}