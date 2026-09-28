<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('zakat.calculator');
});

Route::get('/dashboard', function () {
    $user = Illuminate\Support\Facades\Auth::user()->load('beneficiary.fileRenewals');
    return view('dashboard', compact('user'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/calculator', function () {
    return view('zakat.calculator');
})->name('calculator');


use App\Http\Controllers\FileRenewalController;
Route::post('/beneficiary/renew-file', [FileRenewalController::class, 'submit'])->middleware('auth');

