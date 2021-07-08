<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/test','indexController@test');

Route::get('/','indexController@index')->name('welcome');

Route::get('/atribuireLocalitate','indexController@atribuireLocalitate');
Route::get('/EcoAtribuire','indexController@EcoAtribuire');

Route::get('/atribuieRol','indexController@rolAtr')->name('atribuieRol');

Route::post('/adauga','indexController@IBANadauga')->name('adauga');
Route::post('/read','indexController@IBANread')->name('read');
Route::post('/sterge','indexController@delete')->name('sterge');
Route::post('/actualizare','indexController@update')->name('actualizare');
Route::post('/atribuie','indexController@set')->name('atribuie');

Route::post('/operator_raion','indexController@operator_raion')->name('operator_raion');
Route::post('/simplu_operator','indexController@simplu_operator')->name('simplu_operator');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
