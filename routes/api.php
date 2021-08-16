<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('app/admin_login', [AdminController::class, 'adminLogin']);

Route::post('app/upload_icon', [AdminController::class, 'uploadIcon']);
Route::post('app/delete_icon', [AdminController::class, 'deleteIcon']);

Route::get('app/get_tag', [AdminController::class, 'listTag']);
Route::post('app/create_tag', [AdminController::class, 'addTag']);
Route::post('app/edit_tag', [AdminController::class, 'editTag']);
Route::post('app/delete_tag', [AdminController::class, 'deleteTag']);

Route::get('app/get_category', [AdminController::class, 'listCategory']);
Route::post('app/create_category', [AdminController::class, 'addCategory']);
Route::post('app/edit_category', [AdminController::class, 'editCategory']);
Route::post('app/delete_category', [AdminController::class, 'deleteCategory']);

Route::get('app/get_user', [AdminController::class, 'listUser']);
Route::post('app/create_user', [AdminController::class, 'addUser']);
Route::post('app/edit_user', [AdminController::class, 'editUser']);
Route::post('app/delete_user', [AdminController::class, 'deleteUser']);
