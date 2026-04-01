<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Paiement;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'passager_id',
        'paiement_id',
        'montant',
        'type',
        'statut',
        'description'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'created_at' => 'datetime'
    ];

    // relation
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    // helpers
    public function estComplete()
    {
        return $this->statut === 'complete';
    }

    public function estEnAttente()
    {
        return $this->statut === 'en_attente';
    }
}