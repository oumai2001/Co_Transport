<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'utilisateur_id',
    ];

    // Relation avec Utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    // Accesseurs pour les champs de l'utilisateur
    public function getNomAttribute()
    {
        return $this->utilisateur->nom ?? null;
    }

    public function getEmailAttribute()
    {
        return $this->utilisateur->email ?? null;
    }

    public function getTelephoneAttribute()
    {
        return $this->utilisateur->telephone ?? null;
    }
}