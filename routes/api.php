<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoNotesController;
use Illuminate\Support\Facades\Route;
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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);

Route::get('todo-notes', [TodoNotesController::class, 'index']);
Route::get('todo-notes/archived', [TodoNotesController::class, 'archived']);
Route::post('todo-notes', [TodoNotesController::class, 'store']);
Route::get('todo-notes/{id}', [TodoNotesController::class, 'show']);
Route::patch('todo-notes/{id}', [TodoNotesController::class, 'update']);
Route::delete('todo-notes/{id}', [TodoNotesController::class, 'destroy']);
Route::patch('todo-notes/{id}/archive', [TodoNotesController::class, 'archive']);
// Route::patch('todo-notes/{id}/unarchive', [TodoNotesController::class, 'unarchive']);