<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/company', CompanyController::class);
    Route::apiResource('/role', RoleController::class);
});
