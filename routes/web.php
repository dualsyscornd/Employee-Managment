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

// --- === All Controller Here === --- \\
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
// --- === All Controller Here === --- \\

// All Routes Here

// --- === Login Routes === --- \\
Route::get('/', [AuthController::class, 'Login']);
Route::get('AdminLogin', [AuthController::class, 'AdminLogin']);
Route::get('Logout', [AuthController::class, 'Logout']);
// --- === Login Routes === --- \\

// --- === Main Group Routes === --- \\
Route::group(['prefix' => 'Admin', 'middleware' => 'AdminMiddleware'], function () {
    // --- === Dashboard Routes === --- \\
    Route::get('Dashboard', [DashboardController::class, 'Dashboard'])->name('Dashboard');
    // --- === Dashboard Routes === --- \\
});
// --- === Main Group Routes === --- \\
