<?php

use App\Http\Controllers\ConnectionTestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MetricsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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
    return redirect('/dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/metrics', [MetricsController::class, 'index'])->name('metrics');

    Route::resource('connection-test', ConnectionTestController::class)->only([ 'index' ]);
});
