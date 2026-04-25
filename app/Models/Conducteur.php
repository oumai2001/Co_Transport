<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;

class Conducteur extends Model
{
    protected $table = 'conducteurs';

    protected $fillable = [
        'utilisateur_id',
        'numero_permis',
        'note_moyenne',
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
    public function vehicules()
    {
        return $this->hasMany(Vehicule::class, 'conducteur_id');
    }

    public function trajets()
    {
        return $this->hasMany(Trajet::class, 'conducteur_id');
    }

    public function avisRecus()
    {
        return $this->hasMany(Avis::class, 'conducteur_id');
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class, 'conducteur_id');
    }

    public function reservations()
    {
        return $this->hasManyThrough(
            Reservation::class,
            Trajet::class,
            'conducteur_id',
            'trajet_id'
        );
    }

    public function getNombreTrajetsAttribute()
    {
        return $this->trajets()->count();
    }

    public function getNombrePassagersAttribute()
    {
        return Reservation::whereHas('trajet', function ($q) {
            $q->where('conducteur_id', $this->id);
        })->where('statut', 'confirmee')->count();
    }

    public function getGainsTotauxAttribute()
    {
        return Reservation::whereHas('trajet', function ($q) {
            $q->where('conducteur_id', $this->id);
        })->where('statut', 'confirmee')->sum('prix_total');
    }
}