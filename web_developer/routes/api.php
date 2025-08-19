<?php

use App\Http\Controllers\Api\Diskon\DiskonController;
use App\Http\Controllers\Api\Pajak\PajakController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/pajak', [PajakController::class, 'index']);

Route::post('/diskon', [DiskonController::class, 'index']);
