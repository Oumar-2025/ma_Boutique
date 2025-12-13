<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BoutiqueController extends Controller
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
            $boutiques = Boutique::get();
            return view('G-Boutique.Boutique.index', compact('boutiques'));
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
            return view('G-Boutique.Boutique.create');
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
        $request->validate([
            'nom' => 'required|string|max:100',
            'logo' => 'nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:2048',
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('boutiques', 'email'), // 👈 empêche le doublon
            ],
            'telephone'      => [
                'required',
                'digits:8',
                'regex:/^(5[0-9]|6[0-9]|7[0-9]|8[0-9]|9[0-9])[0-9]{6}$/',
                'unique:boutiques,telephone',
            ],
            'adresse' => 'nullable|string',
            // 'type_boutique' => 'required|string',
        ], [
            'email.unique'   => 'Email déjà utilisé : vous ne pouvez pas enregistrer une autre boutique avec cet email.',
            'telephone.regex' => 'Le numéro doit commencer par 60 à 99 et contenir exactement 8 chiffres.',
            'telephone.digits' => 'Le numéro doit comporter exactement 8 chiffres.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        ]);

        $data = $request->only(['nom', 'email', 'telephone', 'adresse']);

        if ($request->hasFile('logo')) {
            $fichier = $request->file('logo');

            // Nom du fichier = nom_boutique_sans_espace + timestamp + extension
            $nomFichier = preg_replace('/\s+/', '_', strtolower($request->nom)) . '_' . time() . '.' . $fichier->getClientOriginalExtension();

            // Déplacer le fichier directement dans public/assets/img/boutiques
            $fichier->move(public_path('assets/img/boutiques'), $nomFichier);

            // Enregistrer le chemin relatif dans la DB
            $data['logo'] = 'assets/img/boutiques/' . $nomFichier;
        }

        // Création de la boutique
        Boutique::create($data);

        return redirect()->route('boutique.index')->with('success', 'Boutique ajoutée avec succès.');
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
            $boutique = Boutique::findOrFail($id);
            return view('G-Boutique.Boutique.show', compact('boutique'));
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
            $boutique = Boutique::findOrFail($id);
            return view('G-Boutique.Boutique.edit', compact('boutique'));
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
        $request->validate([
            'nom' => 'required|string|max:100',
            'logo' => 'nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG|max:2048',
            'email' => 'nullable|email|unique:boutiques,email,' . $id,
            // Validation du numéro malien (8 chiffres et préfixe Malitel ou Orange)
            'telephone'      => [
                'required',
                'digits:8',
                'regex:/^(5[0-9]|6[0-9]|7[0-9]|8[0-9]|9[0-9])[0-9]{6}$/',
                'unique:boutiques,telephone',
            ],
            'adresse' => 'nullable|string',
            // 'type_boutique' => 'required|string',
        ], [
            'email.unique'   => 'Email déjà utilisé : vous ne pouvez pas enregistrer une autre boutique avec cet email.',
            'telephone.regex' => 'Le numéro doit commencer par 60 à 99 et contenir exactement 8 chiffres.',
            'telephone.digits' => 'Le numéro doit comporter exactement 8 chiffres.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        ]);

        $boutique = Boutique::findOrFail($id);
        $data = $request->only(['nom', 'email', 'telephone', 'adresse']);

        if ($request->hasFile('logo')) {
            $fichier = $request->file('logo');
            $nomFichier = preg_replace('/\s+/', '_', strtolower($request->nom)) . '_' . time() . '.' . $fichier->getClientOriginalExtension();
            $fichier->move(public_path('assets/img/boutiques'), $nomFichier);
            $data['logo'] = 'assets/img/boutiques/' . $nomFichier;
        }

        $boutique->update($data);
        return redirect()->route('boutique.index')->with('success', 'Boutique mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $boutique = Boutique::findOrFail($id);
        $boutique->delete();
        return redirect()->route('boutique.index')->with('success', 'Boutique supprimée avec succès.');
    }
}
