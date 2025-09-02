<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fournisseurs = Fournisseur::all();
        return view('G-Boutique.Fournisseur.index', compact('fournisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('G-Boutique.Fournisseur.create');
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
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:fournisseurs',
            'adresse' => 'required|string|max:255',
            // Validation du numéro malien (8 chiffres et préfixe Malitel ou Orange)
            'telephone'      => [
                'required',
                'unique:fournisseurs,telephone',
            ],
        ], [
            'email.unique'   => 'Email déjà utilisé : vous ne pouvez pas enregistrer un autre fournisseur avec cet email.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        ]);

        $data = $request->all();
        // $data['boutique_id'] = auth()->user()->boutique_id;
        // $data['annexe_id'] = auth()->user()->annexe_id;
        // $data['user_id'] = auth()->id();

        Fournisseur::create($data);

        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        return view('G-Boutique.Fournisseur.show', compact('fournisseur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        return view('G-Boutique.Fournisseur.edit', compact('fournisseur'));
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
        $fournisseur = Fournisseur::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:fournisseurs,email,' . $fournisseur->id,
            'adresse' => 'required|string|max:255',
            // Validation du numéro malien (8 chiffres et préfixe Malitel ou Orange)
            'telephone'      => [
                'required',
                'unique:clients,telephone',
            ],
        ], [
            'email.unique'   => 'Email déjà utilisé : vous ne pouvez pas enregistrer un autre client avec cet email.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        ]);

        $data = $request->all();
        // $data['boutique_id'] = auth()->user()->boutique_id;
        // $data['annexe_id'] = auth()->user()->annexe_id;
        // $data['user_id'] = auth()->id();

        $fournisseur->update($data);

        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->delete();

        return redirect()->route('fournisseur.index')->with('success', 'Fournisseur supprimé avec succès.');
    }
}
