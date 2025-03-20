<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserAuthController;
use App\Models\SubDomains\User;
use App\Models\ValueObjects\CountryOfOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::put('/user/{id}', [UserAuthController::class, 'update']);
    Route::get('/users', function () {
        return User::all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'permissions' => $user->permissions,
            ];
        });
    });

    Route::apiResource('/company', CompanyController::class);
    Route::apiResource('/project', ProjectController::class);
    Route::get('/countries',function(){
        return CountryOfOperation::COUNTRIES;
    });
});
