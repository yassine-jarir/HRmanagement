<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminManageUsersController;
use App\Http\Controllers\employeeLeaveRequest;
use App\Http\Controllers\pointController;
use App\Http\Controllers\EmployeeProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLeaveReqController;
use App\Http\Controllers\AdminPayrollController;
use App\Http\Controllers\AdminTasksController;
use App\Http\Controllers\EmployeeStatsController;
use App\Http\Controllers\EmoloyeeManageTasksController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])
->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Admin Dashboard Statistics
    Route::get('/dashboard-stats', [AdminDashboardController::class, 'getAdminStats']);
    Route::get('/payroll-chart', [AdminDashboardController::class, 'getAdminPayrollChart']);

    // Admin -- tasks
    Route::get('/tasks', [AdminTasksController::class, 'index']);
    Route::get('/taskss', [AdminTasksController::class, 'show']);
    Route::post('/tasks', [AdminTasksController::class, 'store']);
    Route::put('/tasks/{id}', [AdminTasksController::class, 'update']);
    Route::delete('/tasks/{id}', [AdminTasksController::class, 'destroy']);

    // Admin -- leave request
    Route::get('/leave', [AdminLeaveReqController::class, 'index']);
    Route::post('/leave', [AdminLeaveReqController::class, 'store']);
    Route::put('/leave/{id}', [AdminLeaveReqController::class, 'update']);
    Route::delete('/leave/{id}', [AdminLeaveReqController::class, 'destroy']);

    // Admin -- Manage Employee
    Route::get('/Employee', [AdminManageUsersController::class, 'index']);
    Route::post('/Employee', [AdminManageUsersController::class, 'store']);
    Route::get('/Employee/{id}', [AdminManageUsersController::class, 'show']);
    Route::put('/Employee/{id}', [AdminManageUsersController::class, 'update']);
    Route::delete('Employee/{id}', [AdminManageUsersController::class, 'destroy']);

    // Employee -- pointage 
    Route::post('/startWork', [pointController::class, 'startWork']);
    Route::post('/endWork', [pointController::class, 'endWork']);
    Route::get('/emplyeePoint', [pointController::class, 'index']);

    // Admin -- pointage 
    Route::get('/calculPayroll', [AdminPayrollController::class, 'calculAllPayrolls']);
 
    // Employee Profile Management Routes
    Route::get('/profile', [EmployeeProfileController::class, 'show']);
    Route::put('/employee/profile', [EmployeeProfileController::class, 'update']);

 
    Route::get('/leave-requests', [employeeLeaveRequest::class, 'index']);
    Route::post('/leave-requests', [employeeLeaveRequest::class, 'store']);
    Route::delete('/leave-requests/{id}', [employeeLeaveRequest::class, 'destroy']);
 
    // Employee Statistics Routes
    Route::get('/employee/stats/hoursSalary', [EmployeeStatsController::class, 'calculSalaryHours']);
    Route::get('/employee/stats/tasks', [EmployeeStatsController::class, 'getTaskStats']);
    Route::get('/employee/stats/leaves', [EmployeeStatsController::class, 'getLeaveStats']);
     
    //  employee -- tasks
     Route::PUT('/employee/tasks/{taskId}/status', [EmoloyeeManageTasksController::class, 'updateTaskStatus']);


    //  notifications 
    Route::get('/notifications', [NotificationController::class, 'getNotifications']);
    Route::post('/notifications/{notificationId}/mark-as-read', [NotificationController::class, 'markAsRead']);


});
// payment demo
Route::post('create-checkout-session', [PaymentController::class, 'createCheckoutSession']);