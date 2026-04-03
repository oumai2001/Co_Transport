<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use App\Models\Passager;
use App\Models\Conducteur;

class Avis extends Model
{
    protected $table = 'avis';

    protected $fillable = [
        'reservation_id',
        'passager_id',
        'conducteur_id',
        'note',
        'commentaire'
    ];

    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // relations
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function passager()
    {
        return $this->belongsTo(Passager::class, 'passager_id');
    }

    public function conducteur()
    {
        return $this->belongsTo(Conducteur::class, 'conducteur_id');
    }

   


    public function scopeNote($query, $note)
    {
        return $query->where('note', $note);
    }

    public function scopePourConducteur($query, $id)
    {
        return $query->where('conducteur_id', $id);
    }

    public function scopePourPassager($query, $id)
    {
        return $query->where('passager_id', $id);
    }


    public function getEtoilesAttribute()
    {
        return str_repeat('★', $this->note) .
               str_repeat('☆', 5 - $this->note);
    }

    public function getTexteNoteAttribute()
    {
        return [
            1 => 'Très mauvais',
            2 => 'Mauvais',
            3 => 'Moyen',
            4 => 'Bien',
            5 => 'Excellent'
        ][$this->note] ?? 'Non noté';
    }

    public function getDateFormateeAttribute()
    {
        return $this->created_at?->format('d/m/Y H:i');
    }
}