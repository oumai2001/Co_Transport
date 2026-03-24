<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'niveau_acces',
        'date_embauche',
        'utilisateur_id'
    ];
    
    protected $casts = [
        'date_embauche' => 'date',
    ];
    
    // Relation avec Utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
    
    // Vérifier si c'est un super admin
    public function isSuperAdmin()
    {
        return $this->niveau_acces === 'super_admin';
    }
}