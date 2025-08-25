<?php

use App\Http\Controllers\AnnexeController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
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
