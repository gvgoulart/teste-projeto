<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth:sanctum'])->group(function () {
    
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/delete/{id}', [ProductController::class,'delete'])->name('product_delete');
Route::get('/products/createForm', [ProductController::class,'createForm'])->name('product_createForm');
Route::post('/products/create', [ProductController::class,'create'])->name('product_create');
Route::get('/products/editForm/{id}', [ProductController::class,'editForm'])->name('product_edit_form');
Route::get('/products/edit/{id}', [ProductController::class,'edit'])->name('product_edit');
Route::get('/products/tags/{id}', [ProductController::class,'tags'])->name('product_tags');

Route::get('/tags', [TagController::class, 'index'])->name('tags');
Route::get('/tags/delete/{id}', [TagController::class,'delete'])->name('tag_delete');
Route::get('/tags/createForm', [TagController::class,'createForm'])->name('tag_createForm');
Route::post('/tags/create', [TagController::class,'create'])->name('tag_create');
Route::get('/tags/editForm/{id}', [TagController::class,'editForm'])->name('tag_edit_form');
Route::get('/tags/edit/{id}', [TagController::class,'edit'])->name('tag_edit');
Route::get('/tag/products/{id}', [TagController::class,'products'])->name('tag_products');

Route::get('/tag/product/delete/{product_id}/{tag_id}', [TagController::class,'deleteProductTag'])->name('product_tag_delete');


});