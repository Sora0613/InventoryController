<?php

use App\Http\Controllers\SearchJanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(callback: function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // CRUD routes for Inventory
    Route::resource('inventory', InventoryController::class);

    Route::get('/search', [SearchJanController::class, 'search'])->name('inventory.search');
    Route::post('/search', [SearchJanController::class, 'search'])->name('inventory.search');
});



