<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'employe_id',
        'montant',
        'date_paiement',
        'mois',
        'annee',
        'type',
        'boutique_id',
        'annexe_id',
        'user_id',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}
