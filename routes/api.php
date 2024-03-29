<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
    LoginController,
    RegisterController,
    UserController,
    GroupController
};

use App\Http\Resources\UserResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login',[LoginController::class,'login']);
Route::post('register',[RegisterController::class,'register']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //return $request->user();
    return new UserResource($request->user());
});

Route::middleware(['auth:sanctum','auth'])->group( function () {
    Route::resource('users', UserController::class);
    Route::resource('groups', GroupController::class);
});

