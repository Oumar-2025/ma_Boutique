<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annexe extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'email', 'telephone', 'adresse', 'boutique_id'];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
