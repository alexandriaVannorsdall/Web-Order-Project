<?php

use App\Http\Controllers\OrderController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Define the route group for the Order resource
Route::prefix('orders')->group(function () {

    // GET route to list all orders
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');

    // POST route to create a new order
    Route::post('/', [OrderController::class, 'store'])->name('orders.store');

    // GET route to show a specific order by its reference
    Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');

    // PUT route to update a specific order by reference
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');

    // DELETE route to delete a specific order by ID
    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});
