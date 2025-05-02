<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\CourseController;

Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::post('/', [StudentController::class, 'store']);
    Route::get('{id}', [StudentController::class, 'show']);
    Route::put('{id}', [StudentController::class, 'update']);
    Route::delete('{id}', [StudentController::class, 'destroy']);
    Route::post('{id}/assign-course', [StudentController::class, 'assignCourse']);
    Route::get('{id}/courses', [StudentController::class, 'getCourses']);
});

Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/', [CourseController::class, 'store']);
});

