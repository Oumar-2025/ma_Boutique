<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Caisse;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Vente;
use App\Models\VenteDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if($user->role == 'super_admin' && $user->id == 1) {
            $ventes = Vente::get();
        }
        elseif(in_array($user->role, ['admin', 'gerant']) && $user->boutique_id != null)
        {
            $ventes = Vente::where('boutique_id', $user->boutique_id)->get();
        }
        elseif($user->role == 'caissier' && $user->boutique_id != null && $user->annexe_id != null)
        {
            $ventes = Vente::where('boutique_id', $user->boutique_id)
                            ->where('annexe_id', $user->annexe_id)
                            ->where('user_id', $user->id)
                            ->get();
        }
        else {
            return back()->with('error', "Acccès refusé : Vous n'avez pas la permission d'accéder à cette page.");
        }

        return view('G-Boutique.Vente.index', compact('ventes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produits = Produit::all();
        // $clients = Client::all();
        return view('G-Boutique.Vente.create', compact('produits'));
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
            // 'client_id'     => 'required|exists:clients,id',
            'nom_client'   => 'required|string',
            'tel_client'   => 'required|string',
            'date_vente'    => 'required|date',
            'mode_paiement' => 'required|string',
        ]);

        // try {
        //     DB::beginTransaction();

        $panier = session('panier', []);
        // dd($panier);
        if (empty($panier)) {
            return back()->with('error', 'Le panier est vide');
        }

        $total = 0;

        // Vérifier le stock AVANT d’insérer
        foreach ($panier as $item) {
            $produit = Produit::findOrFail($item['id']);

            if ($produit->stock < $item['quantite']) {
                return back()->with('error', "Stock insuffisant pour le produit {$produit->nom}. Disponible : {$produit->stock}, demandé : {$item['quantite']}");
            }

            $total += $item['quantite'] * $item['prix'];
        }

        // Création de la vente
        $vente = Vente::create([
            // 'client_id'    => $request->client_id,
            'nom_client'   => $request->nom_client,
            'tel_client'   => $request->tel_client,
            'date_vente'   => $request->date_vente,
            'mode_paiement' => $request->mode_paiement,
            'total'        => $total,
            'boutique_id'  => auth()->user()->boutique_id,
            'annexe_id'    => auth()->user()->annexe_id,
            'user_id'      => auth()->id(),
        ]);

        // Insertion des détails et décrémentation du stock
        foreach ($panier as $item) {
            VenteDetail::create([
                'vente_id'     => $vente->id,
                'produit_id'   => $item['id'],
                'quantite'     => $item['quantite'],
                'prix_unitaire' => $item['prix'],
            ]);

            Produit::findOrFail($item['id'])->decrement('stock', $item['quantite']);
        }

        // Création des mouvements de caisse
        Caisse::create([
            'type'         => 'entrée',
            'montant'      => $total,
            'description'  => 'Vente ID #' . $vente->id . ' - Client: ' . $vente->nom_client . ' ' . $vente->tel_client,
            'date_mouvement' => now(),
            'source'      => 'vente',
            'vente_id'    => $vente->id,
            'boutique_id'  => auth()->user()->boutique_id,
            // 'annexe_id'    => auth()->user()->annexe_id,
            'user_id'      => auth()->id(),
        ]);

        // DB::commit();
        if ($request->action === 'valider_imprimer') {
            // Vider le panier après validation
        session()->forget('panier');
            return redirect()->route('ventes.facture', $vente->id);
        }
        // Vider le panier après validation
        session()->forget('panier');

        return back()->with('success', 'Vente enregistrée avec succès ✅');

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
        //Relation imbriquée
        $vente = Vente::with( 'details.produit')->findOrFail($id);
        // dd($vente->details);
        return view('G-Boutique.Vente.show', compact('vente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vente = Vente::with('client')->findOrFail($id);
        $details = VenteDetail::with('produit')->where('vente_id', $id)->get();
        return view('G-Boutique.Vente.edit', compact('vente', 'details'));
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

        $request->validate([
            'client_id'     => 'required|exists:clients,id',
            'date_vente'    => 'required|date',
            'mode_paiement' => 'required|string',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vente = Vente::findOrFail($id);
        $vente->delete();
        return back()->with('success', 'Vente supprimée avec succès ✅');
    }
    //Partie pour modifier et supprimer un détail de vente

    public function updateDetail(Request $request, $id)
    {
        // Validation : seule la quantité est modifiable
        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        $detail = VenteDetail::findOrFail($id);
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

        // Recalculer le total de la vente
        $vente = Vente::findOrFail($detail->vente_id);
        $total = $vente->details()->sum(DB::raw('quantite * prix_unitaire'));
        $vente->update(['total' => $total]);

        return back()->with('success', "Quantité de {$produit->nom} mise à jour ✅");
    }


    public function deleteDetail($id)
    {
        $detail = VenteDetail::findOrFail($id);
        $detail->delete();

        return back()->with('success', 'Détail de vente supprimé avec succès ✅');
    }

    public function telechargerFacture($id)
    {
        $vente = Vente::with(['details.produit'])->findOrFail($id);
        $boutique = Boutique::first(); // récupérer les infos de la boutique (logo, nom, etc.)

        $pdf = Pdf::loadView('G-Boutique.vente.facture', compact('vente', 'boutique'))->setPaper('A4', 'portrait');

        $filename = 'facture_vente_' . $vente->id . '.pdf';

        return $pdf->download($filename);
    }

    public function showFacture($id)
    {
        $vente = Vente::with(['details.produit'])->findOrFail($id);
        $boutique = Boutique::first(); // récupérer les infos de la boutique (logo, nom, etc.)

        return view('G-Boutique.vente.facture', compact('vente', 'boutique'));
    }
}
