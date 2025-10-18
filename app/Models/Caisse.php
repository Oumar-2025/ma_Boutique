<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', // 'entree' ou 'sortie'
        'montant',
        'description',
        'date_mouvement',
        'depense_id',
        'achat_id',
        'boutique_id',
        'annexe_id',
        'user_id',
        'paiement_id',
        'vente_id',
        'source', // 'vente', 'paiement_salaire', 'depense', 'achat', 'autre'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    public function annexe()
    {
        return $this->belongsTo(Annexe::class);
    }
}
