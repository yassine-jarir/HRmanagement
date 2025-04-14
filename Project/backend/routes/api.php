<?php

use App\Http\Controllers\TasksController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveReqController;
use Illuminate\Support\Facades\Route;


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])
->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group( function () {
//  admin 
Route::get('/users', [TasksController::class, 'getUsers']);  

//  admin -- tasks
Route::get('/tasks', [TasksController::class, 'index']);
Route::get('/tasks/{id}', [TasksController::class, 'show']);
Route::post('/tasks', [TasksController::class, 'store']);
Route::put('/tasks/{id}', [TasksController::class, 'update']);
Route::delete('/tasks/{id}', [TasksController::class, 'destroy']);

//  admin -- leave request
Route::get('/leave', [LeaveReqController::class, 'index']);
 Route::post('/leave', [LeaveReqController::class, 'store']);
Route::put('/leave/{id}', [LeaveReqController::class, 'update']);
Route::delete('/leave/{id}', [LeaveReqController::class, 'destroy']);

// admin -- payroll 

});
