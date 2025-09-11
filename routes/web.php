<?php

use App\Http\Controllers\AnnexeController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\PanierVenteController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\VenteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('G-Boutique.dashboard');
});

Route::resource('/dashboard', DashboardController::class);
Route::resource('/boutique', BoutiqueController::class);
Route::resource('/annexe', AnnexeController::class);
Route::resource('/client', ClientController::class);
Route::resource('/fournisseur', FournisseurController::class);
Route::resource('/categorie', CategorieController::class);
Route::resource('/produit', ProduitController::class);
//Suppression et Edition des details de vente
Route::put('/detail-vente/update/{id}', [VenteController::class, 'updateDetail'])->name('detail-vente.update');
Route::delete('/detail-vente/delete/{id}', [VenteController::class, 'deleteDetail'])->name('detail-vente.delete');
Route::get('/ventes/{id}/facture', [VenteController::class, 'telechargerFacture'])->name('ventes.facture');
Route::get('/ventes/{id}/show-facture', [VenteController::class, 'showFacture'])->name('ventes.showFacture');
Route::resource('/ventes', VenteController::class);

Route::post('/panier-vente/ajouter',[PanierVenteController::class,'ajouter'])->name('panier.ajouter');
Route::delete('/panier-vente/supprimer/{id}',[PanierVenteController::class,'supprimer'])->name('panier.supprimer');
Route::get('/panier-vente/vider',[PanierVenteController::class,'viderPanier'])->name('panier.vider');
