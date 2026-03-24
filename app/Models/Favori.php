<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    protected $fillable = [
        'date_ajout',
        'passager_id',
        'trajet_id'
    ];
    
    protected $casts = [
        'date_ajout' => 'datetime',
    ];
    
    // Relation avec Passager
    public function passager()
    {
        return $this->belongsTo(Passager::class);
    }
    
    // Relation avec Trajet
    public function trajet()
    {
        return $this->belongsTo(Trajet::class);
    }
}