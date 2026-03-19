<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PassagerController; 
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PointFideliteController;
use App\Http\Controllers\ConducteurController;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('accueil'))->name('accueil');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Trajets public
Route::get('/trajets', [TrajetController::class, 'index'])->name('trajets.index');
Route::post('/trajets/filtrer', [TrajetController::class, 'filtrer'])->name('trajets.filtrer');
Route::get('/trajet/{id}', [TrajetController::class, 'show'])->name('trajet.show');

// API public
Route::get('/api/trajets/recherche', [TrajetController::class, 'rechercheJSON'])->name('api.trajets.recherche');
Route::get('/api/villes/recherche', [VilleController::class, 'rechercheJSON'])->name('api.villes.recherche');

/*
|--------------------------------------------------------------------------
| Routes PROTÉGÉES
|--------------------------------------------------------------------------
*/

Route::middleware('web')->group(function () {

    // Profil (Tous rôles)
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::delete('/profil', [ProfilController::class, 'deleteAccount'])->name('profil.delete-account');

    // Dashboards
    Route::get('/passager/dashboard', [DashboardController::class, 'passagerDashboard'])->name('passager.dashboard');
    Route::get('/conducteur/dashboard', [DashboardController::class, 'conducteurDashboard'])->name('conducteur.dashboard');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread/count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread.count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Avis
    Route::get('/avis/conducteur/{id}', [AvisController::class, 'index'])->name('avis.conducteur');
    Route::post('/avis', [AvisController::class, 'store'])->name('avis.store');
    Route::post('/avis/{id}/signal', [AvisController::class, 'signal'])->name('avis.signal');

    // Paiement
    Route::get('/paiement/{reservation_id}', [PaiementController::class, 'show'])->name('paiement.show');
    Route::post('/paiement/{reservation_id}/effectuer', [PaiementController::class, 'effectuer'])->name('paiement.effectuer');
    Route::get('/paiement/historique', [PaiementController::class, 'historique'])->name('paiement.historique');

    // Points de fidélité
    Route::get('/passager/points', [PointFideliteController::class, 'index'])->name('passager.points');

    // Favoris - CORRIGÉ : Utilisez POST au lieu de DELETE
    // Route::post('/favori/ajouter/{conducteurId}', [FavoriController::class, 'ajouter'])->name('favori.ajouter');
    // Route::post('/favori/retirer/{conducteurId}', [FavoriController::class, 'supprimerParConducteur'])->name('favori.retirer');
    
    Route::post('/favori/ajouter/{id}', [FavoriController::class, 'ajouter'])->name('favori.ajouter');
Route::delete('/favori/retirer/{conducteurId}', [FavoriController::class, 'supprimerParConducteur'])->name('favori.retirer');
Route::post('/favori/supprimer/{id}', [FavoriController::class, 'supprimer'])->name('favori.supprimer');

// Dans la section des routes protégées, ajoutez :

    // Passager
    Route::get('/passager/historique', [ReservationController::class, 'historique'])->name('passager.historique');
    Route::get('/passager/favoris', [FavoriController::class, 'index'])->name('passager.favoris');
    Route::get('/reservation/{trajet_id}', [ReservationController::class, 'reserver'])->name('reservation.reserver');
    Route::get('/reservation/annuler/{id}', [ReservationController::class, 'annuler'])->name('reservation.annuler');
    Route::post('/reservation/{trajet_id}/confirmer', [ReservationController::class, 'confirmer'])->name('reservation.confirmer');
    Route::post('/avis/modifier/{reservationId}', [ReservationController::class, 'modifierAvis'])->name('avis.modifier');
    Route::post('/conducteur/noter/{id}', [ReservationController::class, 'noterConducteur'])->name('conducteur.noter');
    Route::get('/reservation/{trajet_id}/choisir', [ReservationController::class, 'showReservationForm'])->name('reservation.choisir');

    // Conducteur
    Route::prefix('conducteur')->name('conducteur.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'conducteurDashboard'])->name('dashboard');
        Route::get('/creer-trajet', [TrajetController::class, 'create'])->name('creer-trajet');
        Route::post('/trajet', [TrajetController::class, 'store'])->name('trajet.store');
        Route::get('/mes-trajets', [TrajetController::class, 'mesTrajets'])->name('mes-trajets');
        Route::get('/trajet/{id}/modifier', [TrajetController::class, 'edit'])->name('trajet.edit');
        Route::put('/trajet/{id}', [TrajetController::class, 'update'])->name('trajet.update');
        Route::delete('/trajet/{id}', [TrajetController::class, 'destroy'])->name('trajet.destroy');
        Route::get('/vehicules', [VehiculeController::class, 'index'])->name('vehicules');
        Route::post('/vehicule', [VehiculeController::class, 'store'])->name('vehicule.store');
        Route::delete('/vehicule/{id}', [VehiculeController::class, 'destroy'])->name('vehicule.destroy');
        Route::post('/vehicule/{id}/statut', [VehiculeController::class, 'updateStatut'])->name('vehicule.statut');
        Route::get('/trajet/{id}/passagers', [TrajetController::class, 'voirPassagers'])->name('trajet.passagers');
        Route::post('/trajet/{id}/statut', [TrajetController::class, 'mettreAJourStatut'])->name('trajet.statut');
        Route::get('/statistiques', [StatistiqueController::class, 'conducteurStats'])->name('statistiques');
        Route::get('/mes-avis', [AvisController::class, 'mesAvisConducteur'])->name('mes-avis');
        Route::get('/profil', [ConducteurController::class, 'profil'])->name('profil');
        Route::put('/profil', [ConducteurController::class, 'modifierProfil'])->name('profil.modifier');
    });

    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/passagers', [AdminController::class, 'gererPassagers'])->name('passagers');
        Route::post('/passager/ajouter', [AdminController::class, 'ajouterPassager'])->name('passager.ajouter');
        Route::post('/passager/{id}/bloquer', [AdminController::class, 'bloquerPassager'])->name('passager.bloquer');
        Route::delete('/passager/{id}', [AdminController::class, 'supprimerPassager'])->name('passager.supprimer');
        Route::get('/conducteurs', [AdminController::class, 'gererConducteurs'])->name('conducteurs');
        Route::post('/conducteur/ajouter', [AdminController::class, 'ajouterConducteur'])->name('conducteur.ajouter');
        Route::post('/conducteur/{id}/bloquer', [AdminController::class, 'bloquerConducteur'])->name('conducteur.bloquer');
        Route::delete('/conducteur/{id}', [AdminController::class, 'supprimerConducteur'])->name('conducteur.supprimer');
        Route::get('/trajets', [AdminController::class, 'gererTrajets'])->name('trajets');
        Route::post('/trajet/{id}/valider', [AdminController::class, 'validerTrajet'])->name('trajet.valider');
        // ⚠️ Route DELETE pour admin - URL différente de celle du conducteur
        Route::delete('/admin/trajet/{id}', [AdminController::class, 'supprimerTrajet'])->name('trajet.supprimer');
        Route::get('/vehicules', [AdminController::class, 'gererVehicules'])->name('vehicules');
        Route::delete('/vehicule/{id}', [AdminController::class, 'supprimerVehicule'])->name('vehicule.supprimer');
        Route::get('/reservations', [AdminController::class, 'gererReservations'])->name('reservations');
        Route::post('/reservation/{id}/annuler', [AdminController::class, 'annulerReservation'])->name('reservation.annuler');
        Route::get('/statistiques', [StatistiqueController::class, 'index'])->name('statistiques');
        Route::get('/villes', [VilleController::class, 'index'])->name('villes');
        Route::post('/villes', [VilleController::class, 'store'])->name('villes.store');
        Route::put('/villes/{id}', [VilleController::class, 'update'])->name('villes.update');
        Route::delete('/villes/{id}', [VilleController::class, 'destroy'])->name('villes.destroy');
        Route::get('/avis-signales', [AvisController::class, 'avisSignales'])->name('avis-signales');
        Route::delete('/avis/{id}', [AvisController::class, 'supprimer'])->name('avis.supprimer');
    });
    
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
// Routes pour le profil (dans le groupe middleware('web'))
Route::get('/profil/modifier', [ProfilController::class, 'edit'])->name('profil.modifier');
Route::post('/profil/modifier', [ProfilController::class, 'update'])->name('profil.modifier.post');

Route::get('/reservation/{trajet_id}/confirmer', [ReservationController::class, 'showConfirmationForm'])->name('reservation.confirmer.form');

});