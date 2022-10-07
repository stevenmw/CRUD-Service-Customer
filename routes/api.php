<?php

use App\Http\Controllers\API\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('customer', [CustomerController::class, 'index']);
Route::post('customer/store', [CustomerController::class, 'store']);
Route::get('customer/show/{uuid}', [CustomerController::class, 'show']);
Route::post('customer/update/{uuid}', [CustomerController::class, 'update']);
Route::get('customer/delete/{uuid}', [CustomerController::class, 'destroy']);

Route::resource('/customers', 'CustomerController')->parameters([
    'customers' => 'customers:uuid',
]);
