<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\{
    AuthController,

};

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
Route::get('/', function () {
    return view('welcome');
});
Route::get('show', function () {
    return view('billing');
});


Route::controller(AuthController::class)->prefix('auth/admin')->group(function () {
    Route::post('/login', 'login');
});
require __DIR__ . '/auth.php';