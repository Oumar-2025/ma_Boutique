<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class PanierVenteController extends Controller
{
     public function ajouter(Request $request)
    {
        // Validation
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'prix_vente' => 'required|numeric|min:0',
        ]);

        // Récupérer le produit
        $produit = Produit::findOrFail($request->produit_id);

        // Récupérer le panier existant ou créer un nouveau tableau
        $panier = session()->get('panier', []);

        // Vérifier si le produit est déjà dans le panier
        if (isset($panier[$produit->id])) {
            $panier[$produit->id]['quantite'] += $request->quantite;
            $panier[$produit->id]['prix'] = $request->prix_vente ?? $produit->prix_vente;
        } else {
            $panier[$produit->id] = [
                'nom' => $produit->nom,
                'quantite' => $request->quantite,
                'prix' => $request->prix_vente ?? $produit->prix_vente,
            ];
        }

        // Enregistrer le panier dans la session
        session()->put('panier', $panier);

        // Message de succès et redirection
        return back()->with('success', 'Produit ajouté au panier !');
    }

    public function supprimer($id)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            unset($panier[$id]);
            session()->put('panier', $panier);
        }

        return back()->with('success', 'Produit supprimé du panier.');
    }
}
