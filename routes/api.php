<?php

use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'auth']);
Route::post('/register', [UserController::class, 'create']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('authJWT');
Route::post('/refresh', [LoginController::class, 'refresh'])->middleware('authJWT');

Route::middleware('authJWT')->group(function (){
    Route::prefix('user')->group(function (){
        Route::get('/{id}', [UserController::class, 'single'])->middleware('isSelf');
        Route::get('/', [UserController::class, 'all'])->middleware('isCoordinator');
        Route::put('/{id}', [UserController::class, 'update'])->middleware('isCoordinator');
        Route::delete('/{id}', [UserController::class, 'delete'])->middleware('isCoordinator');
    });

    Route::prefix('student')->group(function(){
        Route::post('/', [StudentController::class, 'create'])->middleware('isCoordinator');
        Route::get('/{id}', [StudentController::class, 'single'])->middleware('isSelf');
        Route::get('/', [StudentController::class, 'all'])->middleware('notStudent');
        Route::put('/{id}', [StudentController::class, 'update'])->middleware('isCoordinator');
        Route::delete('/{id}', [StudentController::class, 'delete'])->middleware('isCoordinator');
    });

    Route::prefix('teacher')->group(function(){
        Route::post('/', [TeacherController::class, 'create'])->middleware('isCoordinator');
        Route::get('/{id}', [TeacherController::class, 'single'])->middleware('isSelf');
        Route::get('/', [TeacherController::class, 'all'])->middleware('notStudent');
        Route::put('/{id}', [TeacherController::class, 'update'])->middleware('isCoordinator');
        Route::delete('/{id}', [TeacherController::class, 'delete'])->middleware('isCoordinator');
    });

    Route::middleware('isCoordinator')->prefix('coordinator')->group(function(){
        Route::post('/', [CoordinatorController::class, 'create']);
        Route::get('/{id}', [CoordinatorController::class, 'single'])->middleware('isSelf');
        Route::get('/', [CoordinatorController::class, 'all']);
        Route::delete('/{id}', [CoordinatorController::class, 'delete']);
    });

    Route::prefix('grade')->group(function(){
        Route::post('/', [GradesController::class, 'create'])->middleware('isTeacher');
        Route::put('/{id}', [GradesController::class, 'update'])->middleware('isTeacher');
        Route::delete('/{id}', [GradesController::class, 'delete'])->middleware('isTeacher');

        Route::get('/student/{student_id}', [GradesController::class, 'mySchoolReport'])->middleware('isSelf');
        Route::get('/teacher/{teacher_id}', [GradesController::class, 'myGradesReleased'])->middleware('isSelf');
        Route::get('/teacher/{teacher_id}/serie/{serie}', [GradesController::class, 'myClassAgenda'])
            ->where('serie', '[0-9]')->middleware('isSelf');
        Route::get('/serie/{serie}', [GradesController::class, 'classAgenda'])->middleware('isCoordinator');
    });
});




