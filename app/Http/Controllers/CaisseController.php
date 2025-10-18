<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use Illuminate\Http\Request;

class CaisseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    $query = Caisse::with(['user', 'boutique', 'annexe']);

    // Filtrage par type (entrée / sortie)
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Filtrage par source (vente, achat, salaire, depense)
    if ($request->filled('source')) {
        $query->where('source', $request->source);
    }

    // Filtrage par dates
    if ($request->filled('date_debut') && $request->filled('date_fin')) {
        $query->whereBetween('date_mouvement', [$request->date_debut, $request->date_fin]);
    }

    // Filtrage par boutique
    if ($request->filled('boutique_id')) {
        $query->where('boutique_id', $request->boutique_id);
    }

    // Filtrage par utilisateur
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    // Récupération avec pagination
    $caisses = $query->orderBy('date_mouvement', 'desc')->paginate(15);

    // Calcul du solde (entrées - sorties)
    $total_entrees = (clone $query)->where('type', 'entrée')->sum('montant');
    $total_sorties = (clone $query)->where('type', 'sortie')->sum('montant');
    $solde = $total_entrees - $total_sorties;
    //dd(view('G-Boutique.Caisses.index', compact('caisses', 'total_entrees', 'total_sorties', 'solde')));
    return view('G-Boutique.Caisses.index', compact('caisses', 'total_entrees', 'total_sorties', 'solde'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $caisse = Caisse::findOrFail($id);
        $caisse->delete();
        return redirect()->route('caisses.index')->with('success', 'Mouvement de caisse supprimé avec succès.');
    }
}
