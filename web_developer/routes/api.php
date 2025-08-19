<?php

use App\Http\Controllers\Api\PajakController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/pajak', [PajakController::class, 'index']);
