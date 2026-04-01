<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passager extends Model
{
    protected $table = 'passagers';

    protected $fillable = [
        'utilisateur_id',
        'est_bloque'
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

    // Relations
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'passager_id');
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class, 'passager_id');
    }
}