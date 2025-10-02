<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employes = Employe::get();

        return view('G-Boutique.Employes.index', compact('employes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('G-Boutique.Employes.create');
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
            'prenom'    =>'required|string|max:255',
            'nom'       =>'required|string|max:255',
            'telephone' =>'required|string|max:100',
            'email'     =>'required|email|unique:employes,email',
            'poste'     =>'required|string|',
            'salaire'   =>'required|numeric|min:0',
            'nomurg'    =>'nullable|string|max:255',
            'telurg'    =>'nullable|string|max:100',
            'relation'  =>'nullable|string|max:255',
        ]);

        $donnees = $request->all();
        $data['boutique_id'] = auth()->user()->boutique_id;
        $data['annexe_id'] = auth()->user()->annexe_id;
        $data['user_id'] = auth()->id();

        Employe::create($donnees);

        return redirect()->route('employes.index')->with('success', "Employés enregistrer avec succès.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employe = Employe::findOrFail($id);

        return view('G-Boutique.Employes.show', compact('employe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employe = Employe::findOrFail($id);

        return view('G-Boutique.Employes.edit', compact('employe'));
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
        $employe = Employe::findOrFail($id);

        $request->validate([
            'prenom'    =>'required|string|max:255',
            'nom'       =>'required|string|max:255',
            'telephone' =>'required|string|max:100',
            'email'     =>'required|email|unique:employes,email,' .$id,
            'poste'     =>'required|string|',
            'salaire'   =>'required|numeric|min:0',
            'nomurg'    =>'nullable|string|max:255',
            'telurg'    =>'nullable|string|max:100',
            'relation'  =>'nullable|string|max:255',
        ]);

        $donnees = $request->all();
        // $data['boutique_id'] = auth()->user()->boutique_id;
        // $data['annexe_id'] = auth()->user()->annexe_id;
        // $data['user_id'] = auth()->id();

        $employe->update($donnees);

        return redirect()->route('employes.index')->with('success', "Employés enregistrer avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employe = Employe::findOrFail($id);
        $employe->delete();

        return redirect()->route('employes.index')->with('success', "Employés supprimer avec succès.");
    }
}
