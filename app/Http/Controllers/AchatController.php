<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\AchatDetail;
use App\Models\Boutique;
use App\Models\Caisse;
use App\Models\Fournisseur;
use App\Models\Produit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AchatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $achats = Achat::with('fournisseur')->get();
        return view('G-Boutique.achats.index', compact('achats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fournisseurs = Fournisseur::get();
        $produits = Produit::get();
        return view('G-Boutique.achats.create', compact('fournisseurs', 'produits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'fournisseur_id'     => 'required|exists:fournisseurs,id',
            'date_achat'    => 'required|date',
            // 'mode_paiement' => 'required|string',
        ]);

        // try {
        //     DB::beginTransaction();

        $panier = session('panier_achat', []);
        // dd($panier);
        if (empty($panier)) {
            return back()->with('error', 'Le panier est vide');
        }

        $total = 0;

        // Vérifier le stock AVANT d’insérer
        foreach ($panier as $item) {
            $produit = Produit::findOrFail($item['id']);

            // if ($produit->stock < $item['quantite']) {
            //     throw new \Exception("Stock insuffisant pour le produit {$produit->nom}. Disponible : {$produit->stock}, demandé : {$item['quantite']}");
            // }

            $total += $item['quantite'] * $item['prix_achat'];
        }

        // Création de l'achat
        $achat = Achat::create([
            'fournisseur_id'    => $request->fournisseur_id,
            'date_achat'   => $request->date_achat,
            // 'mode_paiement' => $request->mode_paiement,
            'total'        => $total,
            'boutique_id'  => auth()->user()->boutique_id,
            'annexe_id'    => auth()->user()->annexe_id,
            'user_id'      => auth()->id(),
        ]);

        // Insertion des détails et décrémentation du stock
        foreach ($panier as $item) {
            AchatDetail::create([
                'achat_id'     => $achat->id,
                'produit_id'   => $item['id'],
                'quantite'     => $item['quantite'],
                'prix_unitaire' => $item['prix_achat'],
            ]);

            Produit::findOrFail($item['id'])->increment('stock', $item['quantite']);
        }

        // Création des mouvements de caisse
        Caisse::create([
            'type'         => 'sortie',
            'montant'      => $total,
            'description'  => 'Achat ID #' . $achat->id . ' - Fournisseur: ' . $achat->fournisseur->prenom . ' ' . $achat->fournisseur->nom,
            'date_mouvement' => now(),
            'source'      => 'achat',
            'achat_id'    => $achat->id,
            'boutique_id'  => auth()->user()->boutique_id,
            // 'annexe_id'    => auth()->user()->annexe_id,
            'user_id'      => auth()->id(),
        ]);

        // DB::commit();
        if ($request->action === 'valider_imprimer') {
            // Vider le panier après validation
        session()->forget('panier_achat');
            return redirect()->route('achats.facture', $achat->id);
        }
        // Vider le panier après validation
        session()->forget('panier_achat');

        return back()->with('success', 'Achat enregistré avec succès ✅');

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return back()->withErrors(['error' => $e->getMessage()]);
        // }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $achat = Achat::with('fournisseur', 'details.produit')->findOrFail($id);
        return view('G-Boutique.achats.show', compact('achat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $achat = Achat::findOrFail($id);
        $achat->delete();
        return back()->with('success', 'Achat supprimé avec succès ✅');
    }

    public function updateDetail(Request $request, $id)
    {
        // Validation : seule la quantité est modifiable
        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        $detail = AchatDetail::findOrFail($id);
        $produit = $detail->produit;

        // Gestion du stock
        $ancienneQuantite = $detail->quantite;
        $nouvelleQuantite = $request->quantite;
        $diff = $nouvelleQuantite - $ancienneQuantite;

        if ($diff > 0) {
            // On augmente la quantité → diminuer le stock
            if ($produit->stock < $diff) {
                return back()->with('error', "Stock insuffisant pour {$produit->nom}. Disponible : {$produit->stock}");
            }
            $produit->stock -= $diff;
        } elseif ($diff < 0) {
            // On diminue la quantité → retourner au stock
            $produit->stock += abs($diff);
        }

        $produit->save();

        // Mise à jour de la quantité du détail
        $detail->quantite = $nouvelleQuantite;
        $detail->save();

        // Recalculer le total de l'achat
        $achat = Achat::findOrFail($detail->achat_id);
        $total = $achat->details()->sum(DB::raw('quantite * prix_unitaire'));
        $achat->update(['total' => $total]);

        return back()->with('success', "Quantité de {$produit->nom} mise à jour ✅");
    }

    public function deleteDetail($id)
    {
        $detail = AchatDetail::findOrFail($id);
        $detail->delete();

        return back()->with('success', 'Détail d\'achat supprimé avec succès ✅');
    }

    public function telechargerFacture($id)
    {
        $achat = Achat::with(['fournisseur', 'details.produit'])->findOrFail($id);
        $boutique = Boutique::first(); // récupérer les infos de la boutique (logo, nom, etc.)

        $pdf = Pdf::loadView('G-Boutique.achat.facture', compact('achat', 'boutique'))->setPaper('A4', 'portrait');

        $filename = 'facture_achat_' . $achat->id . '.pdf';

        return $pdf->download($filename);
    }

    public function showFacture($id)
    {
        $achat = Achat::with(['fournisseur', 'details.produit'])->findOrFail($id);
        $boutique = Boutique::first(); // récupérer les infos de la boutique (logo, nom, etc.)

        return view('G-Boutique.achat.facture', compact('achat', 'boutique'));
    }
}
