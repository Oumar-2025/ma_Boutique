<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Annexe;
use App\Models\Boutique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();

        return view('G-Boutique.Users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boutiques = Boutique::all();
        $annexes = Annexe::all();
        return view('G-Boutique.Users.create', compact('boutiques', 'annexes'));
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
            'name' => 'required|string|max:50',
            'email' => [
            'required',
            'email',
            'max:50',
            Rule::unique('users', 'email'), // 👈 empêche le doublon
        ],
            // 'ville_id' => 'required|string|max:50',
            'role' => 'required|string',
            'boutique_id' => 'nullable|exists:boutiques,id',
            'annexe_id' => 'nullable|exists:annexes,id',
        ], [
        // 🎯 Messages personnalisés
        'email.unique' => 'Cet email est déjà utilisé par un autre utilisateur.',
        'email.required' => 'Le champ email est obligatoire.',
        'email.email' => 'Veuillez saisir une adresse email valide.',
    ]);

        // 🔐 Générer un mot de passe aléatoire
        $plainPassword = Str::random(8); // ex: "a8fjLk9P2z"

        $data = $request->all();
        $data['password'] = Hash::make($plainPassword);
        $data['plain_password'] = $plainPassword;  // <- ici on ajoute le mot de passe en clair
        // $data['boutique_id'] = auth()->user()->boutique_id;
        // $data['annexe_id'] = auth()->user()->annexe_id;
        // $data['user_id'] = auth()->user()->id;
        // $data['creer_par'] = auth()->user()->id;

        // 4️⃣ Créer l'utilisateur avec gestion d'erreur
    try {
        DB::beginTransaction();

        User::create($data);

        DB::commit();

        // 🔁 Redirection avec succès + mot de passe
        return redirect()->route('users.index')
                         ->with('success', "Utilisateur créé avec succès. Mot de passe : {$plainPassword}");

    } catch (\Exception $e) {
        DB::rollBack();

        // ⚠️ Affichage d'un message d'erreur clair
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Impossible de créer l’utilisateur : ' . $e->getMessage());
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
        $user = User::findOrFail($id);

        return view('G-Boutique.Users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('G-Boutique.Users.edit', compact('user'));
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
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            // 'ville_id' => 'required|string|max:50',
            'role' => 'required|string',
            // 'boutique_id' => 'nullable|exists:boutiques,id',
            // 'annexe_id' => 'nullable|exists:annexes,id',
        ]);

        $datas = $request->all();
        $user->update($datas);

        return redirect()->route('users.index')->with('success', 'Utilisateur mise à jour avec succèss.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
