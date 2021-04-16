<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);

        return ['token' => $token->plainTextToken];
    });
});

// Inertia Routing Documentation:
// https://inertiajs.com/routing
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', fn() => inertia('Dashboard/Index'))->name('dashboard');

    Route::group(['prefix' => '/clients'], function () {
        Route::get('/', [Controllers\ClientController::class, 'index'])->name('clients');
        Route::post('/', [Controllers\ClientController::class, 'store'])->name('client.store');
        Route::get('create', fn() => inertia('Client/Create'))->name('client.create');
        Route::get('{id}', [Controllers\ClientController::class, 'show'])->name('client.show');
    });
});
