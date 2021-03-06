<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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
    return view('welcome');
});

Route::get('/contacts',[ContactController::class,'index'])->name('contact.index');

Route::get('/contacts/create',[ContactController::class,'create'])->name('contact.create');

Route::post('/contacts/store',[ContactController::class,'store'])->name('contact.store');

Route::get('/contacts/{id}/edit',[ContactController::class,'edit'])->name('contact.edit');

Route::put('/contacts/{id}', [ContactController::class,'update'])->name('contact.update');

Route::delete('/contacts/{id}', [ContactController::class,'destroy'])->name('contact.destroy');

Route::get('/contacts/{id}', [ContactController::class,'show'])->name('contact.show');