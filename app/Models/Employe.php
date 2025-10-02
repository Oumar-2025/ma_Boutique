<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $fillable = [
        'prenom',
        'nom',
        'telephone',
        'email',
        'poste',
        'salaire',
        'nomurg',
        'telurg',
        'relation',
        'boutique_id',
        'annexe_id',
        'user_id',
    ];
}
