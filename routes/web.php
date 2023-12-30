<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Models\Contact;

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

// Route::get('account', [AccountController::class,'index'])->name('account');
// Route::post('update-account', [AccountController::class,'update'])->name('update-account');

//Route::resource('/contacts', ContactController::class); bu şekilde yapınca aşağıdaki 
//7 taneyi derlemiş toplamış oluyoruz ama bende çakışmadı çok uğraşmadım

Route::get('/contacts',[ContactController::class,'index'])->name('contacts.index');

Route::delete('/contacts/{contact}/restore',[ContactController::class,'restore'])
    ->name('contacts.restore')
    ->withTrashed();
Route::delete('/contacts/{contact}/force-delete',[ContactController::class,'forceDelete'])
    ->name('contacts.forceDelete')
    ->withTrashed();

Route::resource('/contacts', ContactController::class);

// Route::get('/contacts/create',[ContactController::class,'create'])->name('contacts.create');

// Route::post('/contacts/store',[ContactController::class,'store'])->name('contacts.store');

// Route::get('/contacts/{id}/edit',[ContactController::class,'edit'])->name('contacts.edit');

// Route::put('/contacts/{id}', [ContactController::class,'update'])->name('contacts.update');

// Route::delete('/contacts/{id}', [ContactController::class,'destroy'])->name('contacts.destroy');

// Route::get('/contacts/{id}', [ContactController::class,'show'])->name('contacts.show');