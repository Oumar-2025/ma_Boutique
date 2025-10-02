<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Depense;
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
            'libelle' => 'required|string',
            'categorie' => 'required|string',
            'montant' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
        ]);

        $depense = $request->all();
        // $depense['boutique_id'] = auth()->user()->boutique_id;
        // $depense['annexe_id'] = auth()->user()->annexe_id;
        // $depense['user_id'] = auth()->id();

        Depense::create($depense);
         // Création des mouvements de caisse
        // Caisse::create([
        //     'type'         => 'sortie',
        //     'montant'      => $request->montant,
        //     'description'  => 'Dépense ID #' . $depense->id . ' - Libellé: ' . $depense->libelle,
        //     'date_mouvement' => now(),
        //     'source'      => 'depense',
        //     'depense_id'  => $depense->id,
        //     'boutique_id'  => auth()->user()->boutique_id,
        //     // 'annexe_id'    => auth()->user()->annexe_id,
        //     'user_id'      => auth()->id(),
        // ]);

        return redirect()->route('depenses.index')->with('success', 'Dépense enrégistrée avec succès.');
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
