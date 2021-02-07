<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/admin/auth/{id}/','AdminController@index');
Route::post('/admin/auth_admin/','AdminController@auth_admin');


Route::get('/admin/equipes/','AdminController@equipes');
Route::get('/admin/terrains/','AdminController@terrains');
Route::get('/admin/quartiers/','AdminController@quartiers');
Route::get('/admin/reservations/','AdminController@reservations');
Route::get('/admin/abonnements/','AdminController@abonnements');

Route::get('/admin/admins/','AdminController@admins');
Route::get('/admin/getQts/','AdminController@getQts');
Route::post('/admin/delQt/','AdminController@delQt');
Route::post('/admin/addQt/','AdminController@addQt');
Route::post('/admin/editQt/','AdminController@editQt');

Route::get('/admin/getTers/','AdminController@getTers');
Route::post('/admin/addTerr/','AdminController@addTerr');
Route::post('/admin/getTerRes/','AdminController@getTerRes');
Route::post('/admin/editTerr/','AdminController@editTerr');
Route::post('/admin/deleteTerr/','AdminController@deleteTerr');

Route::post('/admin/getResEq/','AdminController@getResEq');
Route::post('/admin/getResTer/','AdminController@getResTer');
Route::post('/admin/delRes/','AdminController@delRes');

Route::post('/admin/findAbn/','AdminController@findAbn');

Route::post('/admin/makeRoot/','AdminController@makeRoot');
Route::post('/admin/delAdmin/','AdminController@delAdmin');
Route::post('/admin/addAdmin/','AdminController@addAdmin');
Route::post('/admin/editAdmin/','AdminController@editAdmin');

Route::get('/','TeamController@index');

Route::post('/checkUserMail','TeamController@checkUserMail');
Route::post('/checkUserCin','TeamController@checkUserCin');
Route::post('/getUserType','TeamController@getUserType');
Route::post('/signupTeam','TeamController@signupTeam');
Route::post('/editTeam','TeamController@editTeam');
Route::post('/loginTeam','TeamController@loginTeam');

Route::post('/getMapData','TeamController@getMapData');
Route::post('/getResTers','TeamController@getResTers');
Route::post('/getResPlan','TeamController@getResPlan');
Route::post('/addRes','TeamController@addRes');
Route::post('/cancelRes','TeamController@cancelRes');

Route::post('/getInv','TeamController@getInvits');
Route::post('/cancelInv','TeamController@cancelInv');
Route::post('/approvInv','TeamController@approvInv');

Route::post('/paymentProcess','TeamController@paymentProcess');
Route::get('/payEx','TeamController@payEx');


Route::resource('admin','AdminController');
Route::resource('','TeamController');



Auth::routes();


