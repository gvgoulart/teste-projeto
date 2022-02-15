<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\TesteController;
use App\Http\Controllers\Api\ProductTagController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::get('teste', [TesteController::class, 'teste']);

Route::middleware(['auth:api'])->group(function () {

    Route::post('logout', [LoginController::class, 'logout']);

    //Lista usarioS
    Route::get('user', [UserController::class, 'getAll']);

    //Lista usuário
    Route::get('user/{id}', [UserController::class, 'getUser']);

    //Edita usuário
    Route::put('edit/{id}', [UserController::class, 'edit']);

    //Deleta usuário
    Route::delete('delete/{id}', [UserController::class, 'delete']);


    //Cria Product
    Route::post('product/create', [ProductController::class, 'create']);

    //Lista Product
    Route::get('product/getAll', [ProductController::class, 'getAll']);
    
    //Lista Product
    Route::get('product/getProduct/{id}', [ProductController::class, 'getProduct']);
        
    //Edita Product
    Route::put('product/edit/{id}', [ProductController::class, 'edit']);
        
    //Deleta Product
    Route::delete('product/delete/{id}', [ProductController::class, 'delete']);

    //Deleta Product
    Route::delete('product/insertOtherTag/{id}', [ProductController::class, 'insertOtherTag']);

    //Cria Tag
    Route::post('tag/create', [TagController::class, 'create']);

    //Lista Todas as Tags
    Route::get('tag/getAll', [TagController::class, 'getAll']);

    //Lista Produtos de uma Tag
    Route::get('tag/getTagProducts/{id}', [TagController::class, 'getTagProducts']);
        
    //Lista Tag
    Route::get('tag/getTag/{id}', [TagController::class, 'getTag']);
            
    //Edita Tag
    Route::put('tag/edit/{id}', [TagController::class, 'edit']);
            
    //Deleta Tag
    Route::delete('tag/delete/{id}', [TagController::class, 'delete']);

    //Cria Tag
    Route::post('product/tag/create', [ProductTagController::class, 'create']);
});
