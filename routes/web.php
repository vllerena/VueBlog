<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


Route::get('/', [AdminController::class, 'index']);
Route::get('/{slug}', [AdminController::class, 'index']);
Route::get('/logout', [AdminController::class, 'logout']);
