// app/Models/Vehicule.php (version corrigée)
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $table = 'vehicules';
    protected $fillable = ['immatriculation', 'modele', 'marque', 'capacite', 'statut', 'conducteur_id'];
    
    // Attributs
    private $id;
    private $immatriculation;
    private $modele;
    private $marque;
    private $capacite;
    private $statut; // enum: disponible, maintenance, en trajet
    
    // Relation
    public function conducteur()
    {
        return $this->belongsTo(Conducteur::class, 'conducteur_id');
    }
    
    public function trajets()
    {
        return $this->hasMany(Trajet::class);
    }
    
    // Méthodes
    public function ajouterVehicule($data)
    {
        $vehicule = new self();
        $vehicule->fill($data);
        return $vehicule->save();
    }
    
    public function modifierVehicule($data)
    {
        return $this->update($data);
    }
    
    public function supprimerVehicule()
    {
        return $this->delete();
    }
}