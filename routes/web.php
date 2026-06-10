<?php

use App\Http\Controllers\StudentController;
// Include Student Controller
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/student');
});

Route::get('/student', [StudentController::class, 'index'])
    ->name('student.index');

Route::get('/student/add', [StudentController::class, 'create'])
    ->name('student.create');
Route::POST('/student/add', [StudentController::class, 'store'])
    ->name('student.store');

Route::get('/student/download/{id}', [StudentController::class, 'download'])
    ->name('student.download');

Route::get('/student/preview/{id}', [StudentController::class, 'preview'])
    ->name('student.preview');

Route::get('/student/{id}', [StudentController::class, 'show'])
    ->name('student.show');

Route::get('/student/edit/{id}', [StudentController::class, 'edit'])
    ->name('student.edit');
Route::PUT('/student/edit/{id}', [StudentController::class, 'update'])
    ->name('student.update');

Route::DELETE('/student/delete/{id}', [StudentController::class, 'destroy'])
    ->name('student.destroy');
