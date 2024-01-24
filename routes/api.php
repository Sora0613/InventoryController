<?php

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

/*Route::apiResource(
    'shoppinglist',
    ShoppingListController::class);

// Userの一覧、ログインのルートの設定
Route::get('user', [UserController::class, 'index']);
Route::post('user/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->get('user/getUserInfo', [UserController::class, 'getUserInfo']);

// Inventoryの一覧、追加、更新、削除、検索のルートの設定
Route::get('inventory', [InventoryController::class, 'index']);

Route::post('inventory/store', [InventoryController::class, 'store']);
*/

Route::post('/authenticate', [UserController::class, 'authenticate']);

Route::get('user', [UserController::class, 'index'])->middleware('auth:sanctum');

Route::post('inventory/store', [InventoryController::class, 'store'])->middleware('auth:sanctum');

