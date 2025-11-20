<?php

use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\API\BuildingController;
use Illuminate\Support\Facades\Route;

Route::get('/buildings', [BuildingController::class, 'index'])->middleware('check.api.key');

Route::middleware(['check.api.key'])
    ->prefix('organizations')
    ->group(function () {
		Route::get('/activity', [OrganizationController::class, 'byActivity']);
        Route::get('/building', [OrganizationController::class, 'byBuilding']);
        Route::get('/name', [OrganizationController::class, 'byName']);
        Route::get('/{id}', [OrganizationController::class, 'show']);

        Route::post('/geo', [OrganizationController::class, 'byGeo']);
    });
