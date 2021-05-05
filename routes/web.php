<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/votes', [VoteController::class, 'index'])->name('votes');
Route::get('/vote/{type}/{id}', [VoteController::class, 'add'])->name('addVote');
Route::get('/', [CourseController::class, 'index'])->name('myCourses');
Route::get('/courses', [CourseController::class, 'add'])->name('courses');
Route::post('/courses', [CourseController::class, 'add'])->name('courses');
Route::get('/join-course/{type}/{id}', [CourseController::class, 'join'])->name('joinCourse');

Auth::routes();