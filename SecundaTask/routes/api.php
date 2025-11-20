<?php

use App\Http\Controllers\API\BuildingController;
use Illuminate\Support\Facades\Route;

Route::get('/buildings', [BuildingController::class, 'index'])
	->middleware('check.api.key');