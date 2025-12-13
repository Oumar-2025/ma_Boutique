<?php

namespace App\Http\Controllers;

use App\Models\Annexe;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnnexeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'super_admin' && $user->id == 1) {
            $annexes = Annexe::with('boutique')->get();
            return view('G-Boutique.Annexe.index', compact('annexes'));
        } else {
            return back()->with('error', "Acccès refusé : Vous n'avez pas la permission d'accéder à cette page.");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->role == 'super_admin' && $user->id == 1) {
            $boutiques = Boutique::get();
            return view('G-Boutique.Annexe.create', compact('boutiques'));
        } else {
            return back()->with('error', "Acccès refusé : Vous n'avez pas la permission d'accéder à cette page.");
        }
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
            'email' => [
            'required',
            'email',
            'max:50',
            Rule::unique('annexes', 'email'), // 👈 empêche le doublon
        ],
            // Validation du numéro malien (8 chiffres et préfixe Malitel ou Orange)
            'telephone'      => [
                'required',
                'digits:8',
                'regex:/^(5[0-9]|6[0-9]|7[0-9]|8[0-9]|9[0-9])[0-9]{6}$/',
                'unique:annexes,telephone',
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
        $user = auth()->user();

        if ($user->role == 'super_admin' && $user->id == 1) {
            $annexe = Annexe::findOrFail($id);
            return view('G-Boutique.Annexe.show', compact('annexe'));
        } else {
            return back()->with('error', "Acccès refusé : Vous n'avez pas la permission d'accéder à cette page.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->user();

        if ($user->role == 'super_admin' && $user->id == 1) {
            $annexe = Annexe::findOrFail($id);
            $boutiques = Boutique::get();
            return view('G-Boutique.Annexe.edit', compact('annexe', 'boutiques'));
        } else {
            return back()->with('error', "Acccès refusé : Vous n'avez pas la permission d'accéder à cette page.");
        }
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
                'unique:annexes,telephone',
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
