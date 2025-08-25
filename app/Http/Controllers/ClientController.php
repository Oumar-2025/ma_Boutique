<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::get();
        return view('G-Boutique.Client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('G-Boutique.Client.create');
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
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email',
            // Validation du numéro malien (8 chiffres et préfixe Malitel ou Orange)
            'telephone'      => [
                'required',
                'digits:8',
                'regex:/^(5[0-9]|6[0-9]|7[0-9]|8[0-9]|9[0-9])[0-9]{6}$/',
                'unique:clients,telephone',
            ],
            'adresse' => 'nullable|string|max:255',
        ], [
            'email.unique'   => 'Email déjà utilisé : vous ne pouvez pas enregistrer un autre client avec cet email.',
            'telephone.regex' => 'Le numéro doit commencer par 60 à 99 et contenir exactement 8 chiffres.',
            'telephone.digits' => 'Le numéro doit comporter exactement 8 chiffres.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        ]);

        $data = $request->all();

        // $data['boutique_id'] = auth()->user()->boutique_id;
        // $data['annexe_id'] = auth()->user()->annexe_id;
        // $data['user_id'] = auth()->id();

        Client::create($data);
        return redirect()->route('client.index')->with('success', "Client enregistré avec succès.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('G-Boutique.Client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('G-Boutique.Client.edit', compact('client'));
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
        $client = Client::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string|max:255',
            // Validation du numéro malien (8 chiffres et préfixe Malitel ou Orange)
            'telephone'      => [
                'required',
                'digits:8',
                'regex:/^(5[0-9]|6[0-9]|7[0-9]|8[0-9]|9[0-9])[0-9]{6}$/',
                'unique:clients,telephone,' . $id,
            ],
        ],[
            'email.unique'   => 'Email déjà utilisé : vous ne pouvez pas enregistrer un autre client avec cet email.',
            'telephone.regex' => 'Le numéro doit commencer par 60 à 99 et contenir exactement 8 chiffres.',
            'telephone.digits' => 'Le numéro doit comporter exactement 8 chiffres.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
        ]);

        $client->update($request->all());
        return redirect()->route('client.index')->with('success', "Client mis à jour avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('client.index')->with('success', "Client supprimé avec succès.");
    }
}
