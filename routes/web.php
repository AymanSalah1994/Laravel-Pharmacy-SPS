<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\UserAddressController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dash', function () {
    return view('layouts.dashboard');
})->name('dashhome');


Route::post('/doctors/ban/{doctor}', [DoctorController::class, 'ban'])->name('doctors.ban');


// This will Be and Admin Route 
Route::get('/pharma/restoreAll', [PharmacyController::class, 'restoreAll'])->name('pharmacies.restore.all');
// Route::get('/pharma/{id}/show', [PharmacyController::class, 'show'])->name('pharmacies.show');
// Route::get('/pharma/{id}/edit', [PharmacyController::class, 'edit'])->name('pharmacies.edit');
// Route::put('/pharma/update', [PharmacyController::class, 'update'])->name('pharmacies.update');
//  Route::delete('/pharma/{id}', [PharmacyController::class, 'destroy'])->name('pharmacies.destroy'); 
//oncedefined as resorxe yoyu cant assign more 



Route::resource('/doctors', DoctorController::class)->middleware('doctor.banned');
Route::resource('/pharmacies', PharmacyController::class);
Route::resource('/medicines', MedicineController::class);
Route::resource('/customers', CustomerController::class);
Route::resource('/areas', AreaController::class);
Route::resource('/useraddresses', UserAddressController::class);
Route::resource('/orders', OrderController::class);  //->middleware('doctor.banned')
Route::resource('/revenues', RevenueController::class);
Route::get('/success', [OrderController::class, 'success'])->name('stripe.success');
Route::get('/cancel', [OrderController::class, 'cancel'])->name('stripe.cancel');
