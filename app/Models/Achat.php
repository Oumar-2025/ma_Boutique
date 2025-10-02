<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    use HasFactory;

    protected $fillable = ['fournisseur_id', 'total', 'date_achat', 'boutique_id', 'annexe_id', 'user_id'];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function details()
    {
        return $this->hasMany(AchatDetail::class, 'achat_id');
    }

}
