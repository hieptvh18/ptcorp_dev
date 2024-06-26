<?php

use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;
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

Route::get('health', HealthCheckResultsController::class);
Route::get('health-check', \Spatie\Health\Http\Controllers\SimpleHealthCheckController::class);
Route::get('/', function () {
    return ['App' => app()->version()];
});

Route::get('/check-server', function () {
    return ['ip' => request()->ip(), 'server_ip' => $_SERVER['SERVER_ADDR'], 'SERVER_NAME' => $_SERVER['SERVER_NAME'], 'SERVER_PORT' => $_SERVER['SERVER_PORT']];
});
// $_SERVER
// require __DIR__ . '/auth.php';


