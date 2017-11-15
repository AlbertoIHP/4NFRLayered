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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['cors','jwt.auth']], function(){
	Route::resource('v1/projects', 'ProjectAPIController');
	Route::resource('v1/stakeholders', 'StakeholderAPIController');
	Route::resource('v1/goals', 'GoalAPIController');
	Route::resource('v1/softgoals', 'SoftgoalAPIController');
	Route::resource('v1/softgoalNfrs', 'SoftgoalNfrAPIController');
	Route::resource('v1/categories', 'CategoryAPIController');
	Route::resource('v1/relevances', 'RelevanceAPIController');
	Route::resource('v1/nfrs', 'NfrAPIController');
	Route::resource('v1/functionalities', 'FunctionalityAPIController');
	Route::resource('v1/areas', 'AreaAPIController');
	Route::resource('v1/permises', 'PermiseAPIController');
	Route::resource('v1/collaborators', 'CollaboratorAPIController');	
});

Route::group(['middleware' => ['cors']], function(){
  Route::post('/login','AuthController@userAuth');
  Route::get('/register/verify/{confirmationCode}', 'UserAPIController@confirm');
  Route::post('/v1/users', 'UserAPIController@store');





  	//Provisorio durante desarrollo
	Route::resource('v1/users', 'UserAPIController');
	Route::resource('v1/roles', 'RoleAPIController');
	Route::resource('v1/professions', 'ProfessionAPIController');

});





