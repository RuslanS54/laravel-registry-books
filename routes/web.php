<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
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

Route::get('/', [SiteController::class, 'index'])->name('index');
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware([\App\Http\Middleware\AdminCheck::class])->group(function (){
    Route::get('/admin/book', [AdminController::class, 'manageBook']);
    Route::post('/admin/book', [AdminController::class, 'insertBook']);
    Route::get('/book/{book}/admin', [AdminController::class, 'bookDetail']);
    Route::post('/book/{book}/admin', [AdminController::class, 'updateBook']);
    Route::delete('/book/{book}/admin', [AdminController::class, 'deleteBook']);
    Route::get('/admin/genre', [AdminController::class, 'manageGenre']);
    Route::post('/admin/genre', [AdminController::class, 'addGenre']);
    Route::get('/genre/{genre}/admin', [AdminController::class, 'genreDetail']);
    Route::post('/genre/{genre}/admin', [AdminController::class, 'updateGenre']);
    Route::delete('/genre/{genre}/admin', [AdminController::class, 'deleteGenre']);
    Route::get('/admin/user', [AdminController::class, 'manageUser']);
    Route::post('/admin/user1', [AdminController::class, 'addUser']);
    Route::get('/user/{user}/admin', [AdminController::class, 'userDetail']);
    Route::post('/user/{user}/admin', [AdminController::class, 'updateUser']);
    Route::delete('/user/{user}/admin', [AdminController::class, 'deleteUser']);
});

    
