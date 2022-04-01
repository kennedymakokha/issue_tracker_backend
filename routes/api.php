<?php

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

Route::apiResource('users', 'API\UserController');
Route::apiResource('issues', 'API\IssueController');
Route::apiResource('services', 'API\ServiceController');
Route::post('/login', ['uses' => 'Api\UserController@login']);
Route::post('/resolve', ['uses' => 'Api\IssueController@set_issue_state']);