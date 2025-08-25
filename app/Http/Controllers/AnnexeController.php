<?php

namespace App\Http\Controllers;

use App\Models\Annexe;
use App\Models\Boutique;
use Illuminate\Http\Request;

class AnnexeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $annexes = Annexe::with('boutique')->get();
        return view('G-Boutique.Annexe.index', compact('annexes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boutiques = Boutique::get();
        return view('G-Boutique.Annexe.create', compact('boutiques'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:annexes,email',
            // Validation du numéro malien (8 chiffres et préfixe Malitel ou Orange)
            'telephone'      => [
                'required',
                'digits:8',
                'regex:/^(5[0-9]|6[0-9]|7[0-9]|8[0-9]|9[0-9])[0-9]{6}$/',
                'unique:clients,telephone',
            ],
            'adresse' => 'nullable|string|max:255',
            'boutique_id' => 'required|exists:boutiques,id',
        ], [
            'email.unique'   => 'Email déjà utilisé : vous ne pouvez pas enregistrer une autre annexe avec cet email.',
            'telephone.regex' => 'Le numéro doit commencer par 60 à 99 et contenir exactement 8 chiffres.',
            'telephone.digits' => 'Le numéro doit comporter exactement 8 chiffres.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        ]);

        Annexe::create($validated);

        return redirect()->route('annexe.index')->with('success', 'Annexe créée avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $annexe = Annexe::findOrFail($id);
        return view('G-Boutique.Annexe.show', compact('annexe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $annexe = Annexe::findOrFail($id);
        $boutiques = Boutique::get();
        return view('G-Boutique.Annexe.edit', compact('annexe', 'boutiques'));
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
        $annexe = Annexe::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:annexes,email,' . $id,
            // Validation du numéro malien (8 chiffres et préfixe Malitel ou Orange)
            'telephone'      => [
                'required',
                'digits:8',
                'regex:/^(5[0-9]|6[0-9]|7[0-9]|8[0-9]|9[0-9])[0-9]{6}$/',
                'unique:clients,telephone',
            ],
            'adresse' => 'nullable|string|max:255',
            'boutique_id' => 'required|exists:boutiques,id',
        ], [
            'email.unique'   => 'Email déjà utilisé : vous ne pouvez pas enregistrer une autre annexe avec cet email.',
            'telephone.regex' => 'Le numéro doit commencer par 60 à 99 et contenir exactement 8 chiffres.',
            'telephone.digits' => 'Le numéro doit comporter exactement 8 chiffres.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        ]);

        $annexe->update($validated);

        return redirect()->route('annexe.index')->with('success', 'Annexe mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $annexe = Annexe::findOrFail($id);
        $annexe->delete();

        return redirect()->route('annexe.index')->with('success', 'Annexe supprimée avec succès.');
    }
}
