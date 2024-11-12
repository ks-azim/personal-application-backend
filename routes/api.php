<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('category/list', [CategoryController::class, 'getAll']);
Route::get('category/{id}', [CategoryController::class, 'getById']);
Route::get('category/delete/{id}', [CategoryController::class, 'delete']);
Route::post('category/create', [CategoryController::class, 'create']);
Route::post('category/update/{id}', [CategoryController::class, 'update']);

Route::get('about', [AboutController::class, 'view']);
Route::post('about/update/{id}', [AboutController::class, 'update']);

Route::get('notification/list', [NotificationController::class, 'getAll']);
Route::get('notification/{id}', [NotificationController::class, 'getById']);

Route::get('project/list', [ProjectController::class, 'getAll']);
Route::get('project/{id}', [ProjectController::class, 'getById']);
Route::get('project/delete/{id}', [ProjectController::class, 'delete']);
Route::post('project/create', [ProjectController::class, 'create']);
Route::post('project/update/{id}', [ProjectController::class, 'update']);

Route::get('quote/list', [QuoteController::class, 'getAll']);
Route::get('quote/{id}', [QuoteController::class, 'getById']);
Route::get('quote/delete/{id}', [QuoteController::class, 'delete']);
Route::post('quote/create', [QuoteController::class, 'create']);
Route::post('quote/update/{id}', [QuoteController::class, 'update']);

Route::get('settings', [SettingsController::class, 'getSettings']);
Route::post('settings/update', [SettingsController::class, 'updateSettings']);

Route::get('slider/list', [SliderController::class, 'getAll']);
Route::get('slider/{id}', [SliderController::class, 'getById']);
Route::get('slider/delete/{id}', [SliderController::class, 'delete']);
Route::post('slider/create', [SliderController::class, 'create']);
Route::post('slider/update/{id}', [SliderController::class, 'update']);

Route::get('slide/list', [SliderController::class, 'getAll']);
Route::get('slide/{id}', [SliderController::class, 'getById']);
Route::get('slide/delete/{id}', [SliderController::class, 'delete']);
Route::post('slide/create', [SliderController::class, 'create']);
Route::post('slide/update/{id}', [SliderController::class, 'update']);

Route::get('social/list', [SocialController::class, 'getAll']);
Route::get('social/{id}', [SocialController::class, 'getById']);
Route::get('social/delete/{id}', [SocialController::class, 'delete']);
Route::post('social/create', [SocialController::class, 'create']);
Route::post('social/update/{id}', [SocialController::class, 'update']);

Route::post('login', [AuthController::class, 'login']);

// Forgot password
// pass reset by email verification 
