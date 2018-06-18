<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SchoolController;

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

Route::group([
        'prefix' => '/'
    ], function () {
    /**
     * non-auth routes
     */
    Route::get('/', function (Request $request) {
        return [
            'message' => 'zaportal'
        ];
    });

    Route::post('auth', AuthController::method('login'));

    /**
     * auth routes
     */

    Route::group([
        'middleware' => 'accessTokenSecurity'
    ], function () {
        Route::get('/user', AuthController::method('current'));  
        
        Route::get('/schools', SchoolController::method('schools'));
    });
});