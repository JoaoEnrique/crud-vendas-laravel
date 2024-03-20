<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    
    // PERFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CLIENTE
    Route::get('/client/create', [ClientController::class, 'create'])->name('client.create'); // create
    Route::post('/client/create', [ClientController::class, 'store'])->name('client.create'); // create
    Route::get('/client', [ClientController::class, 'list'])->name('client.list'); // read
    Route::post('/client/update', [ClientController::class, 'update'])->name('client.update'); // update
    Route::get('/client/update/{id}', [ClientController::class, 'edit'])->name('client.edit'); // update
    Route::delete('/client/delete/{id}', [ClientController::class, 'delete'])->name('client.delete'); //delete

    
    // PRODUTO
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create'); // create
    Route::post('/product/create', [ProductController::class, 'store'])->name('product.create'); // create
    Route::get('/product', [ProductController::class, 'list'])->name('product.list'); // read
    Route::post('/product/update', [ProductController::class, 'update'])->name('product.update'); // update
    Route::get('/product/update/{id}', [ProductController::class, 'edit'])->name('product.edit'); // update
    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete'); //delete
    
    // VENDAS
    Route::get('/sale/create', [SaleController::class, 'create'])->name('sale.create'); // create
    Route::post('/sale/create', [SaleController::class, 'store'])->name('sale.create'); // create
    Route::get('/sale', [SaleController::class, 'list'])->name('sale.list'); // read
    Route::post('/sale/update', [SaleController::class, 'update'])->name('sale.update'); // update
    Route::get('/sale/update/{id}', [SaleController::class, 'edit'])->name('sale.edit'); // update
    Route::delete('/sale/delete/{id}', [SaleController::class, 'delete'])->name('sale.delete'); //delete
    Route::get('/client/{id}', [ClientController::class, 'getById']);
    Route::get('/product/{id}', [ProductController::class, 'getById']);
});

require __DIR__.'/auth.php';
