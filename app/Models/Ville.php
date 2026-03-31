<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Trajet;

class Ville extends Model
{
    protected $table = 'villes';

    protected $fillable = [
        'nom',
        'code_postal',
        'pays'
    ];

    // relations
    public function trajetsDepart()
    {
        return $this->hasMany(Trajet::class, 'ville_depart_id');
    }

    public function trajetsArrivee()
    {
        return $this->hasMany(Trajet::class, 'ville_arrivee_id');
    }
}