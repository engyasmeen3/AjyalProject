<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AttendanceController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\ContractController;
use App\Http\Controllers\API\V1\CourseController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\PlatformController;
use App\Http\Controllers\API\V1\ProjectController;
use App\Http\Controllers\API\V1\PostController;
use App\Http\Controllers\API\V1\StudentController;
use App\Http\Controllers\API\V1\TrainerController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\VisionController;
use App\Http\Controllers\API\V1\GroupController;
use App\Http\Controllers\API\V1\ContactController;
use App\Http\Controllers\API\V1\MessageController;




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
    Route::post('login', [AuthController::class, 'store'])->middleware('auth:sanctum');
    Route::apiResource('attendances', AttendanceController::class);
    Route::apiResource('categories', CategoryController::class);
    
    Route::get('contracts/contracts-count', [ContractController::class,'getCount'])->name('contracts-count');
    Route::apiResource('contracts', ContractController::class);
    Route::get('courses-count', [CourseController::class,'getCourseCount'])->name('courses-count');
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('platforms', PlatformController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('projects', ProjectController::class); 
    Route::get('students-count', [StudentController::class,'getStudentCount'])->name('students-count');
    Route::apiResource('students', StudentController::class);
    Route::apiResource('trainers', TrainerController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('visions', VisionController::class);
    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('groups', GroupController::class);
    Route::apiResource('messages', MessageController::class);
    Route::get('/notifications', [UserController::class, 'index']);




});
