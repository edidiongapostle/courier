<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\RateCalculatorController;

Route::view('/', 'home')->name('home');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware(['auth', 'verified', 'not_blocked'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User shipment request
    Route::get('/shipments/request', [ShipmentController::class, 'create'])->name('shipments.request');
    Route::post('/shipments/request', [ShipmentController::class, 'store'])->name('shipments.store');
    Route::get('/shipments/history', [ShipmentController::class, 'history'])->name('shipments.history');
    Route::get('/shipments/{id}/view', [ShipmentController::class, 'userShow'])->name('shipments.user_show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthenticatedSessionController::class, 'store']);
    Route::post('/logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware(['auth:admin', \App\Http\Middleware\AdminOnly::class, \App\Http\Middleware\NotBlocked::class])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Admin: view pending shipment requests
        Route::get('/shipments/pending', [ShipmentController::class, 'pending'])->name('shipments.pending');
        Route::get('/shipments/create', [ShipmentController::class, 'adminCreate'])->name('shipments.create');
        Route::post('/shipments', [ShipmentController::class, 'adminStore'])->name('shipments.store');
        Route::get('/shipments/{id}/edit', [ShipmentController::class, 'adminEdit'])->name('shipments.edit');
        Route::put('/shipments/{id}', [ShipmentController::class, 'adminUpdate'])->name('shipments.update');
        Route::get('/shipments/{id}', [ShipmentController::class, 'show'])->name('shipments.show');
        Route::post('/shipments/{id}/approve', [ShipmentController::class, 'approve'])->name('shipments.approve');
        Route::post('/shipments/{id}/reject', [ShipmentController::class, 'reject'])->name('shipments.reject');
        // Admin: update package status and view log
        Route::get('/packages/{packageId}/status', [ShipmentController::class, 'packageStatusForm'])->name('packages.status');
        Route::post('/packages/{packageId}/status', [ShipmentController::class, 'updatePackageStatus'])->name('packages.status.update');
        Route::get('/packages/{packageId}/status-log', [ShipmentController::class, 'packageStatusLog'])->name('packages.status.log');
        // Admin: update shipment/package ETA
        Route::get('/shipments/{shipmentId}/eta', [ShipmentController::class, 'shipmentEtaForm'])->name('shipments.eta');
        Route::post('/shipments/{shipmentId}/eta', [ShipmentController::class, 'updateShipmentEta'])->name('shipments.eta.update');
        Route::get('/packages/{packageId}/eta', [ShipmentController::class, 'packageEtaForm'])->name('packages.eta');
        Route::post('/packages/{packageId}/eta', [ShipmentController::class, 'updatePackageEta'])->name('packages.eta.update');
        Route::get('/shipments', [ShipmentController::class, 'adminAll'])->name('shipments.all');
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.all');
        Route::post('/users/{id}/block', [AdminDashboardController::class, 'blockUser'])->name('users.block');
        Route::post('/users/{id}/unblock', [AdminDashboardController::class, 'unblockUser'])->name('users.unblock');
        Route::post('/users/{id}/verify', [AdminDashboardController::class, 'verifyUser'])->name('users.verify');
        Route::delete('/users/{id}', [AdminDashboardController::class, 'deleteUser'])->name('users.delete');
        // Admin test route
        Route::get('/test', function() { return 'Admin test route works!'; });
        Route::post('/shipments/{shipmentId}/status', [ShipmentController::class, 'updateShipmentStatus'])->name('shipments.status.update');
    });
});

// Public tracking page
Route::get('/tracking', [TrackingController::class, 'show'])->name('tracking.show');

// QR code routes
Route::get('/qr/shipment/{tracking}', [TrackingController::class, 'qrShipment'])->name('qr.shipment');
Route::get('/qr/package/{barcode}', [TrackingController::class, 'qrPackage'])->name('qr.package');

// Rate calculator
Route::get('/rate', [RateCalculatorController::class, 'show'])->name('rate.form');
Route::post('/rate', [RateCalculatorController::class, 'calculate'])->name('rate.calculate');

// Public pages
Route::view('/services', 'services')->name('services');
Route::view('/contact', 'contact')->name('contact');
Route::view('/about', 'about')->name('about');
Route::view('/fraud-awareness', 'fraud-awareness')->name('fraud-awareness');
Route::view('/legal-notice', 'legal-notice')->name('legal-notice');
Route::view('/terms-of-use', 'terms-of-use')->name('terms-of-use');
Route::view('/privacy-notice', 'privacy-notice')->name('privacy-notice');
Route::view('/accessibility', 'accessibility')->name('accessibility');

require __DIR__.'/auth.php';
