<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Utilisateur extends Model
{
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
        'email_verified_at' => 'datetime',
    ];
    
    // Mutateur pour hacher le mot de passe
    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = Hash::make($value);
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
    
    // Vérifier si le compte est actif
    public function isActif()
    {
        return $this->statut_compte === 'actif';
    }
}