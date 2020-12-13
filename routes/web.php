<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('/dashboard', function () {
        return Inertia\Inertia::render('Dashboard/Index');
    })->name('dashboard');

    Route::group(['prefix' => '/clients'], function () {
        Route::get('/', function () {
            return Inertia\Inertia::render('Client/Index');
        })->name('clients');
        Route::get('create', function () {
            return Inertia\Inertia::render('Client/Create');
        })->name('client.create');
    });
});
