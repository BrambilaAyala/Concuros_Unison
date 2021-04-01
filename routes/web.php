<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
})->name('/');
//Route::redirect('/', '/register')->middleware('guest')->name('/');

Auth::routes();

Route::resource('asistentes', 'AsistenteController');

//Route::resource('revisores', 'RevisoresController');

Route::prefix('revisores')->group(function () {
    Route::get('/', 'RevisoresController@index')->name('revisores.index');
    Route::get('/lista-espera', 'RevisoresController@listaEspera')->name('revisores.lista-espera');
    Route::get('/{revisore}/validacion', 'RevisoresController@edit')->name('revisores.edit');
    Route::get('/lista-asistentes', 'RevisoresController@listaAsistentes')->name('revisores.lista-asistentes');
    Route::get('/lista-inscritos', 'RevisoresController@listaInscritos')->name('revisores.lista-inscritos');
    
});

Route::get('admin', 'Auth\LoginRevisorController@showLoginForm')->middleware('guest');
Route::post('admin/login', 'Auth\LoginRevisorController@login')->name('admin.login');
Route::post('admin/logout', 'Auth\LoginRevisorController@logout')->name('admin.logout');
