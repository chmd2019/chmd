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
    return view('auth.login');
});

//Dashboard

Route::get('dashboard','DashboardController@index')->name('dashboard');

//Login
Route::post('login','Auth\LoginController@login')->name('login');

//catalogo de niveles
Route::get('nivel','CatalogoNivelController@index');
Route::get('nivel/create','CatalogoNivelController@create');
Route::get('nivel/edit/{id}','CatalogoNivelController@edit');
Route::post('nivel/store','CatalogoNivelController@store');
Route::post('nivel/update/{id}','CatalogoNivelController@update');
Route::get('nivel/destroy/{id}','CatalogoNivelController@destroy');
//catalogo de alumnos
Route::get('alumnos','AlumnoController@index');
Route::post('alumnos/search','AlumnoController@search');
//catalogo de padres
Route::get('padres','PadreController@index');
Route::post('padres/search','PadreController@search');
//Route::get('busqueda/{apellido}','PadreController@searchApellidos');

//catalogo de circulares
Route::get('circulares','CircularController@index');
Route::post('circulares/search','CircularController@search');
Route::get('circulares/create','CircularController@create');
Route::get('circulares/edit/{id}','CircularController@edit');
Route::post('circulares/store','CircularController@store');
Route::post('circulares/update/{id}','CircularController@update');
Route::get('circulares/delete/{id}','CircularController@delete');

//Catalogo de grupos administrativos
Route::get('gruposAdmin','GrupoAdminController@index');
Route::get('gruposAdmin/create','GrupoAdminController@create');
Route::post('gruposAdmin/store','GrupoAdminController@store');
Route::get('gruposAdmin/edit/{id}','GrupoAdminController@edit');
Route::post('gruposAdmin/update/{id}','GrupoAdminController@update');
Route::get('gruposAdmin/destroy/{id}','GrupoAdminController@destroy');
Route::post('gruposAdmin/asoc/{id}','GrupoAdminController@asoc');
Route::get('gruposAdmin/deasoc/{id}','GrupoAdminController@deasoc');
Route::get('gruposAdmin/asociar/{id}','GrupoAdminController@asociar');

//Catalogo de grupos especiales
Route::get('gruposEspeciales','GrupoEspecialController@index');
Route::get('gruposEspeciales/create','GrupoEspecialController@create');
Route::post('gruposEspeciales/store','GrupoEspecialController@store');
Route::post('gruposEspeciales/asoc/{id}','GrupoEspecialController@asoc');
Route::get('gruposEspeciales/deasoc/{id}','GrupoEspecialController@deasoc');
Route::get('gruposEspeciales/edit/{id}','GrupoEspecialController@edit');
Route::get('gruposEspeciales/asociar/{id}','GrupoEspecialController@asociar');
Route::post('gruposEspeciales/update/{id}','GrupoEspecialController@update');
Route::get('gruposEspeciales/destroy/{id}','GrupoEspecialController@destroy');


