<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchatDetail extends Model
{
    use HasFactory;

    protected $table = 'achats_details';
    protected $fillable = ['achat_id', 'produit_id', 'quantite', 'prix_unitaire'];

    public function achat()
    {
        return $this->belongsTo(Achat::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
