<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PharmacyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['verify' => true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/starter', function () {
    return view('starter');
});
Route::get('/dash', function () {
    return view('layouts.dashboard');
});


Route::resource('/doctors', DoctorController::class);
Route::resource('/pharmacies', PharmacyController::class);




// This will Be and Admin Route 
Route::get('/pharma/restoreAll', [PharmacyController::class, 'restoreAll'])->name('pharmacies.restore.all');
Route::get('/pharma/{id}/show', [PharmacyController::class, 'show'])->name('pharmacies.show');
Route::get('/pharma/{id}/edit', [PharmacyController::class, 'edit'])->name('pharmacies.edit');
Route::put('/pharma/update', [PharmacyController::class, 'update'])->name('pharmacies.update');
//  Route::delete('/pharma/{id}', [PharmacyController::class, 'destroy'])->name('pharmacies.destroy'); 
//oncedefined as resorxe yoyu cant assign more 
