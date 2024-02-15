<?php

use App\Http\Controllers\SearchJanController;
use App\Http\Controllers\ShoppingListController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LineNotificationController;

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

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(callback: function () {
    // CRUD routes for Inventory
    Route::resource('inventory', InventoryController::class)->middleware('verified');

    // Search routes for Inventory
    Route::get('/search', [SearchJanController::class, 'search'])->name('inventory.search');
    Route::post('/search', [SearchJanController::class, 'search'])->name('inventory.search');

    Route::get('/collaborators', [CollaboratorController::class, 'index'])->name('collaborators.index');
    Route::get('/collaborators/add', [CollaboratorController::class, 'create'])->name('collaborators.create');
    Route::delete('/collaborators/{collaborator}/remove', [CollaboratorController::class, 'delete'])->name('collaborators.destroy');

    // 招待関連
    Route::get('/collaborators/share', [CollaboratorController::class, 'share'])->name('collaborators.share');
    Route::get('/collaborators/search', [CollaboratorController::class, 'search'])->name('collaborators.search');
    Route::get('/collaborators/invite/{share_id}', [CollaboratorController::class, 'invited'])->name('collaborators.invited');

    //買い物リスト関係
    Route::resource('shoppinglist', ShoppingListController::class);

    //ユーザー関係
    Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/edit', [UserController::class, 'update'])->name('user.update');

    // Line関係
    Route::get('/line', [LineNotificationController::class, 'index'])->name('line.index');

    Route::get('/line/login', [LineNotificationController::class, 'lineLogin'])->name('line.login');
    Route::get('/line/callback', [LineNotificationController::class, 'callback'])->name('line.callback');
    Route::get('/line/logout', [LineNotificationController::class, 'lineLogout'])->name('line.logout');

    // ダークモード切り替え
    Route::post('/theme', [UserController::class, 'ToggleTheme'])->name('toggleDarkMode');
});
