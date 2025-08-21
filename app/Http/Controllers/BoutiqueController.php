<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoutiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boutiques = Boutique::get();

        return view('G-boutique.Boutique.index', compact('boutiques'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('G-Boutique.Boutique.create');
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
            'icon' => 'nullable|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'email' => 'nullable|email|unique:boutiques,email',
            'telephone' => 'required|string',
            'adresse' => 'nullable|string',
            'type_boutique' => 'required|string',
        ]);

        $data = $request->only(['nom', 'email', 'telephone', 'adresse', 'type_boutique']);

        if($request->hasFile('icon')){
            $fichier = $request->file('icon');

            // Nom du fichier sans espace + timestamp
            $nomFichier = 'icon_' . time() . '.' . $fichier->getClientOriginalExtension();

            // Stocker le logo ou icon original est facultatif
            $fichier->storeAs('logo/originals', $nomFichier, 'public');

            //Chemin pour le stockage
            $cheminStockage = 'logos/min_' . pathinfo($nomFichier, PATHINFO_FILENAME);

            // Enregistrer dans le stockage public
            Storage::disk('public')->put($cheminStockage, $fichier);
            
            //Enregistrement dans la base de données
            $data['icon'] = $cheminStockage;

            //Enregistrement le tout dans la bdd á travers le model
            Boutique::create($data);

            return redirect()->route('boutique.index')->with("success", "Boutique crée avec succés.");

        }
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
