<?php

use App\Http\Controllers\Api\CollaboratorController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\ShoppingListController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/authenticate', [UserController::class, 'authenticate']); //login処理
Route::post('/register', [UserController::class, 'register']); //register処理

Route::middleware('auth:sanctum')->group(function ()
{
    //inventoryのルート設定。
    Route::get('inventory', [InventoryController::class, 'index']); //一覧を取得
    Route::post('inventory/store', [InventoryController::class, 'store']);
    Route::post('inventory/directStore', [InventoryController::class, 'directStore']);
    Route::post('inventory/update/{id}', [InventoryController::class, 'update']);
    Route::delete('inventory/delete/{id}', [InventoryController::class, 'destroy']);
    Route::post('inventory/addQuantity/{id}', [InventoryController::class, 'addQuantity']);
    Route::post('inventory/reduceQuantity/{id}', [InventoryController::class, 'reduceQuantity']);

    //shoppinglistのルート設定。
    Route::get('shoppinglist', [ShoppingListController::class, 'index']);
    Route::post('shoppinglist/store', [ShoppingListController::class, 'store']);
    Route::delete('shoppinglist/delete/{id}', [ShoppingListController::class, 'destroy']);

    //collaboratorのルート設定。
    Route::get('collaborator', [CollaboratorController::class, 'index']);
    Route::post('collaborator/store', [CollaboratorController::class, 'store']);
    Route::post('collaborator/share', [CollaboratorController::class, 'share']);
    Route::post('collaborator/search', [CollaboratorController::class, 'search']);
    Route::delete('collaborator/delete/{id}', [CollaboratorController::class, 'delete']);



    //Userのルート設定。
    Route::get('user/logout', [UserController::class, 'logout']);
});

