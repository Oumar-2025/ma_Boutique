<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\AnnexeController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PanierAchatController;
use App\Http\Controllers\PanierVenteController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\UserController;
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
    return view('G-Boutique.Login.login');
});
Route::get('/login', function () {
    return view('G-Boutique.Login.login');
});
//Route de connexion
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
//Routes protégées par le middleware 'is-admin'
Route::group(['middleware' => ['auth', 'is-admin']], function () {

Route::resource('/dashboard', DashboardController::class);
Route::resource('/boutique', BoutiqueController::class);
Route::resource('/annexe', AnnexeController::class);
// Route::resource('/client', ClientController::class);
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

//Route des achats
Route::post('/panier-achat/ajouter',[PanierAchatController::class,'ajouter'])->name('ajouterAu.panier');
Route::delete('/panier-achat/supprimer/{id}', [PanierAchatController::class,'supprimer'])->name('supprimerAu.panier');
Route::get('/panier-achat/vider', [PanierAchatController::class,'viderPanier'])->name('viderAu.panier');
Route::put('/detail-achat/update/{id}', [AchatController::class, 'updateDetail'])->name('detail-achat.update');
Route::delete('/detail-achat/delete/{id}', [AchatController::class, 'deleteDetail'])->name('detail-achat.delete');
Route::get('/achats/{id}/facture', [AchatController::class, 'telechargerFacture'])->name('achats.facture');
Route::get('/achats/{id}/show-facture', [AchatController::class, 'showFacture'])->name('achats.showFacture');
Route::resource('/achats', AchatController::class);

//Route employés
Route::resource('employes', EmployeController::class);
//Route depenses
Route::resource('depenses', DepenseController::class);
//Route Paiements
Route::resource('paiements', PaiementController::class);
//Route Caisses
Route::resource('caisses', CaisseController::class);

//Route Utilisateur
Route::resource('/users', UserController::class);

// require __DIR__.'/auth.php';
});
