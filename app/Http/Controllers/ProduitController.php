<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = Produit::all();
        return view('G-Boutique.Produit.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('G-Boutique.Produit.create', compact('categories'));
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
            'categorie_id' => 'required|exists:categories,id',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nom', 'categorie_id', 'prix_achat', 'prix_vente', 'stock');
        // Génération du code-barre (ici un nombre aléatoire de 12 chiffres)
        $data['code_barre'] = mt_rand(100000000000, 999999999999);

        // $data['boutique_id'] = auth()->user()->boutique_id;
        // $data['annexe_id'] = auth()->user()->annexe_id;
        // $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $fichier = $request->file('image');

            // Nom du fichier = nom_boutique_sans_espace + timestamp + extension
            $nomFichier = preg_replace('/\s+/', '_', strtolower($request->nom)) . '_' . time() . '.' . $fichier->getClientOriginalExtension();

            // Déplacer le fichier directement dans public/assets/img/produits
            $fichier->move(public_path('assets/img/produits'), $nomFichier);

            // Enregistrer le chemin relatif dans la DB
            $data['image'] = 'assets/img/produits/' . $nomFichier;
        }

        Produit::create($data);

        return redirect()->route('produit.index')->with('success', 'Produit ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Categorie::all();
        $produit = Produit::findOrFail($id);
        return view('G-Boutique.Produit.show', compact('produit', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        $categories = Categorie::all();
        return view('G-Boutique.Produit.edit', compact('produit', 'categories'));
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
        $produit = Produit::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nom', 'categorie_id', 'prix_achat', 'prix_vente', 'stock');

        if ($request->hasFile('image')) {
            $fichier = $request->file('image');
            $nomFichier = preg_replace('/\s+/', '_', strtolower($request->nom)) . '_' . time() . '.' . $fichier->getClientOriginalExtension();
            $fichier->move(public_path('assets/img/produits'), $nomFichier);
            $data['image'] = 'assets/img/produits/' . $nomFichier;
        }

        $produit->update($data);

        return redirect()->route('produit.index')->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();

        return redirect()->route('produit.index')->with('success', 'Produit supprimé avec succès.');
    }
}
