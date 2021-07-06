<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\AuthController;

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

// public routes
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/questions', [QuestionController::class, 'index']);
Route::post('/questions/store', [QuestionController::class, 'store']);
Route::get('/questions/show/{question_id}', [QuestionController::class, 'show'])->where(['question_id' => '[0-9]+']);
Route::get('/questions/search/{name}', [QuestionController::class, 'search']);
Route::put('/questions/update/{id}', [QuestionController::class, 'update']);
Route::delete('/questions/delete/{id}', [QuestionController::class, 'destroy']);

// protected routes
Route::group(['middleware'=> ['auth:sanctum']], function () {

    Route::post('/logout',[AuthController::class, 'logout']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
