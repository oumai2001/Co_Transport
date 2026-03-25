<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;  // ← Ajouter cette ligne

class Utilisateur extends Model
{
    use HasApiTokens;  // ← Ajouter cette ligne
    
    protected $table = 'utilisateurs';
    
    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'telephone',
        'type',
        'photo',
        'statut_compte',
        'date_inscription'
    ];
    
    protected $hidden = [
        'mot_de_passe',
    ];
    
    protected $casts = [
        'date_inscription' => 'date',
    ];
    
    // Mutateur pour hacher le mot de passe
    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = bcrypt($value);
    }
    
    // Relations
    public function passager()
    {
        return $this->hasOne(Passager::class, 'utilisateur_id');
    }
    
    public function conducteur()
    {
        return $this->hasOne(Conducteur::class, 'utilisateur_id');
    }
    
    public function admin()
    {
        return $this->hasOne(Admin::class, 'utilisateur_id');
    }
    
    // Vérifier le rôle
    public function isPassager()
    {
        return $this->type === 'passager';
    }
    
    public function isConducteur()
    {
        return $this->type === 'conducteur';
    }
    
    public function isAdmin()
    {
        return $this->type === 'admin';
    }
}