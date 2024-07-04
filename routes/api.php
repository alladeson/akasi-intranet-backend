<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\MemberController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/reset/password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('report', ReportController::class);
    Route::post('report/validate/{report}', [ReportController::class, 'checked']);
    Route::apiResource('permission', PermissionController::class);
    Route::post('permission/cancel/{permission}', [PermissionController::class, 'cancel']);
    Route::apiResource('users', UserController::class);
     Route::get('users_removed', [UserController::class, 'desactivatedIndex']);
    Route::post('users_restore/{id}', [UserController::class, 'restoreUser']);
    Route::apiResource('teams', TeamController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::get('projects/teams/{id}', [TeamController::class, 'showTeams']);
    Route::apiResource('members', MemberController::class);
    Route::get('teams/members/{id}', [MemberController::class, 'showTeamMember']);
    Route::get('auth/user_current', [UserController::class, 'getCurrentUser']);
    Route::put('auth/password/reset/{user}', [AuthController::class, 'updatePassword']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
});
