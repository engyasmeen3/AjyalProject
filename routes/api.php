<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ContractController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\PlatformController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\TrainerController;
use App\Http\Controllers\API\UserController;

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

Route::group([], function () {
    Route::apiResource('attendances', AttendanceController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('contracts', ContractController::class);
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('platforms', PlatformController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('trainers', TrainerController::class);
    Route::apiResource('users', UserController::class);
});
