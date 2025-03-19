<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Models\ValueObjects\CountryOfOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/company', CompanyController::class);
    Route::apiResource('/project', ProjectController::class);
    Route::get('/countries',function(){
        return CountryOfOperation::COUNTRIES;
    });
});
