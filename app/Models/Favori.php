<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Passager;
use App\Models\Conducteur;

class Favori extends Model
{
    protected $table = 'favoris';

    protected $fillable = [
        'passager_id',
        'conducteur_id',
        'date_ajout'
    ];

    protected $casts = [
        'date_ajout' => 'datetime'
    ];

    // relations
    public function passager()
    {
        return $this->belongsTo(Passager::class, 'passager_id');
    }

    public function conducteur()
    {
        return $this->belongsTo(Conducteur::class, 'conducteur_id');
    }
}