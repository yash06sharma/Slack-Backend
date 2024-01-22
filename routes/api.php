<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);

//-------------Community--------------
Route::get('communitymember/{Cmtid}/channel/{chID}', [DashboardController::class, 'communityMember']);
Route::post('addchannel/{id}', [DashboardController::class, 'addChannel']);
Route::post('addcommunity/{id}', [DashboardController::class, 'addCommunity']);


Route::get('user/{user_id}/community/{comm_ID}/member', [DashboardController::class, 'getCommunityMember']);


Route::get('community/{id?}', [DashboardController::class, 'showCommunity']);




