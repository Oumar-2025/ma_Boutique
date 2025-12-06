<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caisse;
use App\Models\Employe;
use App\Models\Paiement;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $paiements = Paiement::with('employe')
        ->where('boutique_id', $user->boutique_id)
        ->latest()->get();

        return view('G-Boutique.Paiements.index', compact('paiements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employes = Employe::all();
        return view('G-Boutique.Paiements.create', compact('employes'));
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
            'employe_id' => 'required|exists:employes,id',
            'montant' => 'required|numeric|min:0',
            'mois' => 'required|string',
            'annee' => 'required|string',
            'date_paiement' => 'required|date',
            // 'type' => 'required|string|max:50'
        ]);

        //Récupéré l'employé concerné
        $employe = Employe::findOrFail($request->employe_id);
        $montant = $request->montant ?? $employe->salaire;

        //Vérification du solde de la caisse avant le paiement
        $entree = Caisse::where('type', 'entree')->sum('montant');
        $sortie = Caisse::where('type', 'sortie')->sum('montant');
        $soldeCaisse = $entree - $sortie;

        if($soldeCaisse < $montant){
            return redirect()->back()->with('error', 'Solde de la caisse insuffisant pour effectuer ce paiement.');
        }

        //Enregistrement du paiement dans la caisse
        $paiement = Paiement::create([
            'employe_id' =>  $employe->id,
            'montant' => $montant,
            'mois' => $request->mois,
            'annee' => $request->annee,
            'type' => 'salaire',
            'date_paiement' => $request->date_paiement,
            'boutique_id' => auth()->user()->boutique_id,
            'user_id' => auth()->user()->id,
        ]);

        //Enregistrement de la sortie dans la caisse
        $caisse = Caisse::create([
        'type' => 'sortie',
        'montant' => $montant,
        'description' => 'Paiement du salaire de l\'employé : ' . $employe->prenom . ' ' . $employe->nom,
        'date_mouvement' => now(),
        'boutique_id' => auth()->user()->boutique_id,
        'user_id' => auth()->user()->id,
        'paiement_id' => $paiement->id,
        'source' => 'paiement_salaire',
        ]);

        // dd( route('paiements.index'));
        return redirect()->route('paiements.index')->with('success', 'Paiement effectué avec succès.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paiement = Paiement::findOrFail($id);
        $employe = Employe::findOrFail($paiement->employe_id);
        return view('G-Boutique.Paiements.show', compact('paiement', 'employe'));
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
        $paiement = Paiement::findOrFail($id);
        $paiement->delete();

        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès.');
    }
}
