<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get("get_users",[UserController::class,'getUsers'])->name("users.getUsers");
Route::get("get_user/{id}",[UserController::class,'getUser'])->name("users.getUser");
Route::post("login",[UserController::class,'index'])->name("users.login");
Route::post("register",[UserController::class,'store'])->name("users.register");
Route::get("profile",[UserController::class,'getProfile'])->name("users.profile")->middleware('auth:sanctum');
Route::patch("update_profile/{id}",[UserController::class,'updateProfile'])->name("users.updateProfile")->middleware('auth:sanctum');
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('get_users', [AdminController::class, 'getUsers']);
    Route::get('get_cats', [AdminController::class, 'getCats']);
    Route::get('get_cat/{id}', [AdminController::class, 'getCat']);
    Route::post('add_cat', [AdminController::class, 'addCat']);
    Route::patch('update_cat/{id}', [AdminController::class, 'updateCat']);
    Route::patch('update_user/{id}', [AdminController::class, 'updateUser']);
    Route::delete('delete_user/{id}', [AdminController::class, 'deleteUser']);
});
Route::apiResource('products', ProductController::class);
