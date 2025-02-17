<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
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


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);
    Route::post('permissions/assign', [PermissionController::class, 'assignToRole']);
    Route::post('users/assign-role', [UserRoleController::class, 'assignRole']);
    Route::post('users/remove-role', [UserRoleController::class, 'removeRole']);
});

Route::middleware(['auth:sanctum', 'role:HR'])->group(function () {
    Route::get('/hr-dashboard', function () {
        return response()->json(['message' => 'Welcome to HR module']);
    });
});

