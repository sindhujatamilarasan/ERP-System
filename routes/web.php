<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesOrderController;
use Illuminate\Support\Facades\Route;

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
require __DIR__.'/auth.php';


Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::group(['middleware' => ['auth']], function () {



    Route::get('user/{text}/avatar.jpg', [HomeController::class, 'userDefaultAvatar'])->name('default-avatar');

    Route::group(['middleware' => ['auth', 'role:1']], function () {
        Route::get('products', [ProductController::class, 'index'])->name('product.index');
        Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('product', [ProductController::class, 'store'])->name('product.store');
        Route::get('product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('product/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('product/{id}/delete',[ProductController::class, 'delete'])->name('product.delete');
    });

    Route::group(['middleware' => ['auth', 'role:1,2']], function () {
        Route::get('/sales-orders', [SalesOrderController::class, 'index'])->name('sales_orders.index');
        Route::get('/sales-orders/create', [SalesOrderController::class, 'create'])->name('sales_orders.create');
        Route::post('/sales-orders', [SalesOrderController::class, 'store'])->name('sales_orders.store');
        Route::get('/sales-orders/{id}', [SalesOrderController::class, 'show'])->name('sales_orders.show');
        Route::get('/sales-orders/{id}/pdf', [SalesOrderController::class, 'exportPDF'])->name('sales_orders.export');
        Route::delete('/sales-orders/{id}/delete',[SalesOrderController::class, 'delete'])->name('sales_orders.delete');
    });


});


