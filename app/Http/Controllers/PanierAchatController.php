<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class PanierAchatController extends Controller
{
    public function ajouter(Request $request)
    {
        // Validation
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'prix_achat' => 'nullable|numeric|min:0',
            'prix_vente' => 'nullable|numeric|min:0',
        ]);

        // Récupérer le produit
        $produit = Produit::findOrFail($request->produit_id);

        // Récupérer le panier achat existant ou créer un nouveau tableau
        $panierAchat = session()->get('panier_achat', []);

        // Vérifier si le produit est déjà dans le panier
        if (isset($panierAchat[$produit->id])) {
            $panierAchat[$produit->id]['quantite'] += $request->quantite;
            $panierAchat[$produit->id]['prix_achat'] = $request->prix_achat ?? $produit->prix_achat;
            $panierAchat[$produit->id]['prix_vente'] = $request->prix_vente ?? $produit->prix_vente;
        } else {
            $panierAchat[$produit->id] = [
                'id' => $produit->id,
                'nom' => $produit->nom,
                'quantite' => $request->quantite,
                'prix_achat' => $request->prix_achat ?? $produit->prix_achat,
                'prix_vente' => $request->prix_vente ?? $produit->prix_vente,
            ];
        }

        // Enregistrer le panier achat dans la session
        session()->put('panier_achat', $panierAchat);

        return back()->with('success', 'Produit ajouté au panier d\'achat !');
    }

    public function supprimer($id)
    {
        $panierAchat = session()->get('panier_achat', []);

        if (isset($panierAchat[$id])) {
            unset($panierAchat[$id]);
            session()->put('panier_achat', $panierAchat);
        }

        return back()->with('success', 'Produit supprimé du panier d\'achat.');
    }

    public function viderPanier()
    {
        session()->forget('panier_achat');
        return back()->with('success', 'Panier d\'achat vidé avec succès.');
    }
}
