<?php

use Illuminate\Http\Request;

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
Route::post('auth/login', 'Api\\AuthController@login');
// Route::post('users', 'Api\\UserController@index');

Route::group(['middleware' => ['apiJwt']], function(){
    Route::post('auth/logout', 'Api\\AuthController@logout');
    Route::get('auth/refresh', 'Api\\AuthController@refresh');
    Route::post('auth/me', 'Api\\AuthController@me');
    Route::get('users', 'Api\\UserController@index');

    Route::get('products', 'Api\\ProductController@index');
    Route::post('products', 'Api\\ProductController@store');
    Route::post('products/{id}', 'Api\\ProductController@update');
    Route::delete('products/{id}', 'Api\\ProductController@destroy');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
