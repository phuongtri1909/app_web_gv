<?php

use App\Http\Controllers\API\DepartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DigitalTransformationController;

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

Route::middleware(['zalo.auth'])->group(function () {
    Route::group(['prefix' => 'client'], function () {
        Route::get('digital-transformations', [DigitalTransformationController::class, 'index']);
        Route::get('departments', [DepartmentController::class, 'index']);
    });
});
