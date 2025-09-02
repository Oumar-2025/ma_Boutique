<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'code_barre',
        'prix_achat',
        'prix_vente',
        'stock',
        'image',
        'categorie_id',
        'boutique_id',
        'annexe_id',
        'user_id'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

}
