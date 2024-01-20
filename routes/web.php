<?php

use App\Http\Controllers\SearchJanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CollaboratorController;

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

//set guest middleware for welcome page
Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Auth::routes();

Route::middleware(['auth'])->group(callback: function () {
    // CRUD routes for Inventory
    Route::resource('inventory', InventoryController::class);

    // Search routes for Inventory
    Route::get('/search', [SearchJanController::class, 'search'])->name('inventory.search');
    Route::post('/search', [SearchJanController::class, 'search'])->name('inventory.search');

    // CRUD routes for Collaborator
    Route::get('/collaborators', [CollaboratorController::class, 'index'])->name('collaborators.index');
    Route::get('/collaborators/add', [CollaboratorController::class, 'addUser'])->name('collaborators.create');
    Route::post('/collaborators/add', [CollaboratorController::class, 'store'])->name('collaborators.store');
    Route::get('/collaborators/{collaborator}', [CollaboratorController::class, 'show'])->name('collaborators.show');
    Route::delete('/collaborators/{collaborator}/remove', [CollaboratorController::class, 'deleteUser'])->name('collaborators.destroy');
});



