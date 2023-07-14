<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function (){
    Route::post('updateBook/{book}', [\App\Http\Controllers\ForRestAPIController::class, 'updateBook']);
    Route::post('deleteBook/{book}', [\App\Http\Controllers\ForRestAPIController::class, 'deleteBook']);
    Route::post('updateAuthor/{user}', [\App\Http\Controllers\ForRestAPIController::class, 'updateAuthor']);
});

Route::get('books', [\App\Http\Controllers\ForRestAPIController::class, 'BooksAndAuthors']);
Route::get('authors', [\App\Http\Controllers\ForRestAPIController::class, 'AuthorsAndNumberBooks']);
Route::get('genres', [\App\Http\Controllers\ForRestAPIController::class, 'GenresAndBooks']);
Route::get('books/{book}', [\App\Http\Controllers\ForRestAPIController::class, 'Book']);
Route::get('authors/{user}', [\App\Http\Controllers\ForRestAPIController::class, 'Author']);
Route::post('login', [AuthController::class, 'loginApiUser'])->name('login');