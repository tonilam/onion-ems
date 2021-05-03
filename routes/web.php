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
        Route::put('{id}', [Controllers\ClientController::class, 'update'])->name('client.update');
    });

    Route::group(['prefix' => '/companies'], function () {
        Route::get('/', [Controllers\CompanyController::class, 'index'])->name('companies');
        Route::post('/', [Controllers\CompanyController::class, 'store'])->name('company.store');
        Route::get('{id}', [Controllers\CompanyController::class, 'show'])->name('company.show');
        Route::put('{id}', [Controllers\CompanyController::class, 'update'])->name('company.update');
    });

    Route::group(['prefix' => '/people'], function () {
        Route::get('/', [Controllers\PersonController::class, 'index'])->name('people');
        Route::post('/', [Controllers\PersonController::class, 'store'])->name('person.store');
        Route::get('{id}', [Controllers\PersonController::class, 'show'])->name('person.show');
        Route::put('{id}', [Controllers\PersonController::class, 'update'])->name('person.update');
    });
});
