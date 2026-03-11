<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes publiques (pas besoin de connexion)
Route::get('/suivi', function () {
    return view('public.tracking');
})->name('tracking');

Route::post('/suivi/recherche', [App\Http\Controllers\TrackingController::class, 'recherche'])->name('tracking.search');

// Authentification
Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
Route::post('/connexion', [AuthController::class, 'login']);
Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
Route::post('/inscription', [AuthController::class, 'register']);
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');



// Dashboard Client
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Envois
    Route::get('/envois/nouveau', [DashboardController::class, 'createEnvoi'])->name('envois.create');
    Route::post('/envois', [DashboardController::class, 'storeEnvoi'])->name('envois.store');
    Route::get('/envois/{id}', [DashboardController::class, 'showEnvoi'])->name('envois.show');
    
    // NOUVELLE ROUTE : Liste complète des envois
    Route::get('/mes-envois', [DashboardController::class, 'mesEnvois'])->name('envois.liste');
    
    // Profil
    Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');
    Route::put('/profil/update', [DashboardController::class, 'updateProfil'])->name('profil.update');
    Route::put('/profil/password', [DashboardController::class, 'updatePassword'])->name('profil.password');
});

// Routes Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Envois
    Route::get('/envois', [AdminController::class, 'envois'])->name('envois');
    Route::get('/envois/{id}', [AdminController::class, 'showEnvoi'])->name('envois.show');
    Route::post('/envois/{id}/status', [AdminController::class, 'updateStatus'])->name('envois.updateStatus');
    Route::post('/envois/{id}/paiement', [AdminController::class, 'updatePaiement'])->name('envois.updatePaiement');
    
    // Statistiques
    Route::get('/statistiques', [AdminController::class, 'statistiques'])->name('statistiques');
    
    // Clients
    Route::get('/clients', [AdminController::class, 'clients'])->name('clients');
    Route::get('/clients/{id}', [AdminController::class, 'showClient'])->name('clients.show');
    
    // Admins (Super Admin uniquement)
    Route::get('/admins', [AdminController::class, 'admins'])->name('admins');
    Route::post('/admins/create', [AdminController::class, 'createAdmin'])->name('admins.create');
    Route::delete('/admins/{id}', [AdminController::class, 'deleteAdmin'])->name('admins.delete');
});