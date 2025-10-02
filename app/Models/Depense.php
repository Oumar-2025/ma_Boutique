<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $table = ['depenses'];
    protected $fillable = ['libelle', 'montant', 'categorie', 'date_paiement', 'boutique_id', 'annexe_id', 'user_id'];
}
