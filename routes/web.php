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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//Route::post('/login', 'Auth\AdvAuth@auth');

Route::get('/home', 'HomeController@index');

Route::resource('users', 'UserController');

Route::resource('objects', 'ObjectController');

Route::get('/admin/users','UserController@showUsers');
Route::delete('/admin/users/delete/{id}','UserController@destroyUser');
Route::post('/admin/users/confirm/{id}','UserController@confirmUser');
Route::post('/admin/users/block/{id}','UserController@blockUser');
Route::post('/admin/users/role/{id}','UserController@adminUser');

Route::get('/objects','ObjectController@showObjects');
Route::delete('/objects/delete/{id}','ObjectController@destroyObject');
Route::post('/objects/info/{id}','ObjectController@showContactInfo');
Route::post('/objects/block/{id}','ObjectController@blockObject');

Route::get('/admin/categories',['uses'=>'CategoryController@manageCategory']);
Route::post('/admin/categoryAdd', 'CategoryController@addCategory');
