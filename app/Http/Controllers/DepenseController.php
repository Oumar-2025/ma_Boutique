<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Caisse;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depenses = Depense::get();

        return view('G-Boutique.Depenses.index', compact('depenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('G-Boutique.Depenses.create');
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
            'libelle' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'categorie' => 'required|string|max:255',
            'date_depense' => 'required|date',
        ]);

        //Total montant des dépenses
        $montant = $request->montant;

        //Vérification du solde de la caisse avant les dépenses
        $entree = Caisse::where('type', 'entree')->sum('montant');
        $sortie = Caisse::where('type', 'sortie')->sum('montant');
        $soldeCaisse = $entree - $sortie;

        if($soldeCaisse < $montant){
            return back()->with('error', 'Solde insuffisant dans la caisse pour effectuer cette dépense.');
        }

        //Création de la dépense
        $depenses = Depense::create([
            'libelle' => $request->libelle,
            'montant' => $request->montant,
            'categorie' => $request->categorie,
            'date_depense' => $request->date_depense,
            'boutique_id' => auth()->user()->boutique_id,
            'annexe_id' => auth()->user()->annexe_id,
            'user_id' => auth()->user()->id,
        ]);

        //Enregistrement de la dépense dans la caisse
        $caisses = Caisse::create([
            'type' => 'sortie',
            'montant' => $montant,
            'description' => 'Depense : ' . $request->libelle,
            'date_mouvement' => now(),
            'boutique_id' => auth()->user()->boutique_id,
            'user_id' => auth()->user()->id,
            'depense_id' => $depenses->id,
            'source' => 'depense',
        ]);

        return redirect()->route('depenses.index')->with('success', 'Dépense créée avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
