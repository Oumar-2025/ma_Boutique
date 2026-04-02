<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caisse;
use Illuminate\support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        // Définir la portée selon le rôle
        if ($user->role == 'super_admin') {
            $caisse = Caisse::query();
        } elseif ($user->role == 'admin' || $user->role == 'gerant') {
            $caisse = Caisse::where('boutique_id', $user->boutique_id);
        } else { // caissier
            $caisse = Caisse::where('user_id', $user->id);
        }

        // Totaux par période
        $totaux = [
            'ventes_jour'   => $caisse->whereDate('created_at', $today)->where('type', 'vente')->sum('montant'),
            'achats_jour'   => $caisse->whereDate('created_at', $today)->where('type', 'achat')->sum('montant'),

            'ventes_semaine' => $caisse->whereBetween('created_at', [$startOfWeek, $today])->where('type', 'vente')->sum('montant'),
            'achats_semaine' => $caisse->whereBetween('created_at', [$startOfWeek, $today])->where('type', 'achat')->sum('montant'),

            'ventes_mois'   => $caisse->whereBetween('created_at', [$startOfMonth, $today])->where('type', 'vente')->sum('montant'),
            'achats_mois'   => $caisse->whereBetween('created_at', [$startOfMonth, $today])->where('type', 'achat')->sum('montant'),

            'ventes_annee'  => $caisse->whereBetween('created_at', [$startOfYear, $today])->where('type', 'vente')->sum('montant'),
            'achats_annee'  => $caisse->whereBetween('created_at', [$startOfYear, $today])->where('type', 'achat')->sum('montant'),
        ];

        // Graphique : Ventes et Achats mensuelles
        $labels = [];
        $ventes_mensuelles = [];
        $achats_mensuelles = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create(null, $i)->format('F');
            $ventes_mensuelles[] = $caisse->whereMonth('created_at', $i)
                                         ->whereYear('created_at', now()->year)
                                         ->where('type', 'vente')
                                         ->sum('montant');
            $achats_mensuelles[] = $caisse->whereMonth('created_at', $i)
                                         ->whereYear('created_at', now()->year)
                                         ->where('type', 'achat')
                                         ->sum('montant');
        }

        return view('G-Boutique.dashboard', compact(
            'totaux', 'labels', 'ventes_mensuelles', 'achats_mensuelles', 'user'
        ));
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
        //
    }
}
