<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'nom',
        'email',
        'adresse',
        'telephone',
        'type_boutique',
    ];
}
