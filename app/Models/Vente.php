<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    protected $table = 'ventes';
    protected $fillable = [
        'client_id'   ,
        'date_vente'  ,
        'mode_paiement',
        'total'       ,
        'boutique_id' ,
        'annexe_id',
        'user_id'  ,
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function details()
    {
        return $this->hasMany(VenteDetail::class, 'vente_id');
    }
}
