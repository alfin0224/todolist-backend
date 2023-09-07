<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::get('/tasks/{id}', [TaskController::class, 'show']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
Route::get('/tasks/{id}/send-manual-reminder', [TaskController::class, 'sendManualReminderEmail']);
Route::post('/tasks/{id}/send-reminder', [TaskController::class, 'sendReminderEmail']);
Route::get('/tasks-summary', [TaskController::class, 'summary']);
Route::get('/completed-tasks', [TaskController::class, 'completedTasks']);
Route::get('/upcoming-deadlines', [TaskController::class, 'upcomingDeadlines']);