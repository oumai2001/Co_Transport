<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Utilisateur extends Model
{
    protected $table = 'utilisateurs';
    protected $fillable = ['nom', 'email', 'motDePasse', 'telephone'];
    protected $hidden = ['motDePasse'];
    
    // Attributs protégés (# dans le diagramme)
    protected $id;
    protected $nom;
    protected $email;
    protected $motDePasse;
    protected $telephone;
    
    public function sAuthentifier($email, $password)
    {
        if ($this->email === $email && $this->motDePasse === md5($password)) {
            return true;
        }
        return false;
    }
    
    public function modifierProfil($data)
    {
        $this->update($data);
        return true;
    }
}