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
Auth::routes();


Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');
Route::post('/cart/add', 'HomeController@add')->name('add');
Route::post('/cart/remove', 'HomeController@remove')->name('remove');
Route::post('/cart/update', 'HomeController@update')->name('update');


Auth::routes();

Route::get('/', 'HomeController@index')->name('welcome');
