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
Route::post('/login', 'Auth\AdvAuth@auth');

Route::get('/home', 'HomeController@index');

Route::resource('users', 'UserController');

Route::resource('categories', 'CategoryController');

Route::get('/admin/users','UserController@showUsers');
Route::delete('/admin/users/delete/{id}','UserController@destroyUser');
Route::post('/admin/users/confirm/{id}','UserController@confirmUser');
Route::post('/admin/users/block/{id}','UserController@blockUser');
Route::post('/admin/users/role/{id}','UserController@adminUser');

Route::resource('objects', 'ObjectController');
Route::get('/objects','ObjectController@showObjects');
Route::delete('/objects/delete/{id}','ObjectController@destroyObject');
Route::post('/objects/info/{id}','ObjectController@showContactInfo');
Route::post('/objects/block/{id}','ObjectController@blockObject');
Route::get('/userobjects', 'ObjectController@indexUserObjects');
Route::get('/objects/category/{id}','ObjectController@indexCategoryObjects');

Route::get('/admin/categories',['uses'=>'CategoryController@manageCategory']);
Route::get('/admin/categories/add/{parent_id}', 'CategoryController@create');
Route::get('/admin/categories/edit/{id}', 'CategoryController@edit');
Route::get('/admin/categories/delete/{id}', 'CategoryController@delete');

Route::resource('requests', 'RequestController');
Route::get('/requests','RequestController@showRequests');
Route::delete('/requests/delete/{id}','RequestController@destroyRequest');
Route::post('/requests/info/{id}','RequestController@showRequestContact');
Route::post('/requests/block/{id}','RequestController@blockRequest');
Route::get('/userrequests', 'RequestController@indexUserRequests');
Route::get('/requests/category/{id}','RequestController@indexCategoryRequests');
