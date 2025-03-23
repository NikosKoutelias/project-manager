<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserAuthController;
use App\Models\ValueObjects\CountryOfOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::put('/user/{id}', [UserAuthController::class, 'update']);
    Route::delete('/user/{id}', [UserAuthController::class, 'destroy']);
    Route::get('/users', [UserAuthController::class, 'index']);
    Route::post('/user', [UserAuthController::class, 'create']);

    Route::get('/companies/{userId}', [CompanyController::class, 'perUser'])->name('companies.perUser');
    Route::get('/projects/{userId}', [ProjectController::class, 'perUser'])->name('projects.perUser');
    Route::apiResource('/company', CompanyController::class);
    Route::apiResource('/project', ProjectController::class);
    Route::get('/countries', function () {
        return CountryOfOperation::COUNTRIES;
    });
});
