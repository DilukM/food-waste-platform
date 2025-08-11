<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\RequestController;


Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        // Only redirect donors, let recipients see welcome page
        if ($user->canDonate() && !$user->canReceive()) {
            // Pure donors go to manage donations
            return redirect()->route('donations.manage');
        } elseif ($user->canDonate() && $user->canReceive()) {
            // Both role users go to dashboard
            return redirect()->route('dashboard');
        }
        // Recipients (canReceive && !canDonate) stay on welcome page
    }
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

// Public routes - accessible without authentication
Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Donation management routes for donors  
    Route::get('/dashboard/manage', [DonationController::class, 'manage'])->name('donations.manage');
    Route::get('/donations/create', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/{donation}/edit', [DonationController::class, 'edit'])->name('donations.edit');
    Route::patch('/donations/{donation}', [DonationController::class, 'update'])->name('donations.update');
    Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');

    // Request routes
    Route::post('donations/{donation}/request', [RequestController::class, 'store'])->name('donations.request');
    Route::get('/my-requests', [RequestController::class, 'index'])->name('my-requests');
    Route::patch('/requests/{request}/status', [RequestController::class, 'updateStatus'])->name('requests.update-status');
});

// Public donation detail route - must be after /donations/create to avoid conflicts
Route::get('/donations/{donation}', [DonationController::class, 'show'])->name('donations.show');

require __DIR__ . '/auth.php';
