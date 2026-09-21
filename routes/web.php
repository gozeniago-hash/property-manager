<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ConcernController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantPortal\AuthenticatedSessionController as TenantAuthenticatedSessionController;
use App\Http\Controllers\TenantPortal\BillController as TenantBillController;
use App\Http\Controllers\TenantPortal\ConcernController as TenantConcernController;
use App\Http\Controllers\TenantPortal\DashboardController as TenantDashboardController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('properties', PropertyController::class);
    Route::resource('units', UnitController::class)->except(['show']);
    Route::resource('tenants', TenantController::class);
    Route::resource('bills', BillController::class)->except(['show']);
    Route::resource('concerns', ConcernController::class)->except(['show']);

    Route::post('/bills/{bill}/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
});

// Tenant portal — separate login/session guard ('tenant') from the property
// manager's admin area above. Tenants can only see their own bills and concerns.
Route::prefix('portal')->name('tenant.')->group(function () {
    Route::middleware('guest:tenant')->group(function () {
        Route::get('/login', [TenantAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [TenantAuthenticatedSessionController::class, 'store']);
    });

    Route::post('/logout', [TenantAuthenticatedSessionController::class, 'destroy'])
        ->name('logout')
        ->middleware('auth:tenant');

    Route::middleware('auth:tenant')->group(function () {
        Route::get('/', [TenantDashboardController::class, 'index'])->name('dashboard');
        Route::get('/bills', [TenantBillController::class, 'index'])->name('bills.index');

        Route::get('/concerns', [TenantConcernController::class, 'index'])->name('concerns.index');
        Route::get('/concerns/new', [TenantConcernController::class, 'create'])->name('concerns.create');
        Route::post('/concerns', [TenantConcernController::class, 'store'])->name('concerns.store');
        Route::get('/concerns/{concern}', [TenantConcernController::class, 'show'])->name('concerns.show');
    });
});
