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

Route::group([

    // 'middleware' => ['auth:users'],
    'prefix' => 'auth'

], function ($router) {
    
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout')->middleware('auth:users');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user', 'AuthController@me')->middleware('auth:users');
});


// Route::post('login', 'LoginController@login');
Route::post('crediario', 'CrediarioController@store');
Route::post('crediario/{uuid}/completar-cadastro', 'CrediarioController@completar');
Route::get('crediario/{uuid}/visualizar', 'CrediarioController@visualizar');

Route::group(['middleware' => 'auth:users'], function () {
    Route::resource('crediarios', 'CrediarioController');
    Route::post('crediario/{id}/validar', 'CrediarioController@validar');
    Route::post('crediario/{id}/aprovar', 'CrediarioController@aprovar');
    Route::resource('anexos', 'AnexoCrediarioController');
    Route::post('anexo/{id}/aprovar', 'AnexoCrediarioController@aprovar');
    Route::post('anexo/{id}/rejeitar', 'AnexoCrediarioController@rejeitar');
});
