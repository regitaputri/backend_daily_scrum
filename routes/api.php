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

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::middleware(['jwt.verify'])->group(function(){
    Route::get('/scrum', 'ScrumController@index');
    Route::get('/scrum/{id}', 'ScrumController@show');
    Route::post('scrum', 'ScrumController@store');
    Route::put('/scrum/{id}', 'ScrumController@update');
    Route::delete('/scrum/{id}', 'ScrumController@destroy');

    Route::get('scrum', 'ScrumController@scrum');
    Route::get('scrumall', 'ScrumController@scrumAuth');
    Route::get('user', 'UserController@getAuthenticatedUser');
});
