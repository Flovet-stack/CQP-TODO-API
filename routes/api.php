<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TodoController;

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

// owner routes 
Route::post('/register', [OwnerController::class, 'addOwner']);
Route::get('/login', [OwnerController::class, 'getSingleOwner']);

//project routes
Route::post('/create-project', [ProjectController::class, 'addProject']);

// all todo routesT
Route::post('/create-todo', [TodoController::class, 'addTodo']);
Route::put('/update-todo', [TodoController::class, 'updateTodo']);
Route::delete('/delete-todo', [TodoController::class, 'deleteTodo']);
Route::get('/all-undone-todos', [TodoController::class, 'getAllUndoneTodos']);
Route::get('/all-done-todos', [TodoController::class, 'getAlldoneTodos']);
Route::get('/all-started-todos', [TodoController::class, 'getAllStartedTodos']);