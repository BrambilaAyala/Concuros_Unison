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

/* Route::get('/', function () {
    return view('auth.register');
})->name('/'); */
Route::redirect('/', '/register')->middleware('guest')->name('/');
//Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
/* Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register'); */

Route::resource('asistentes', 'AsistenteController');
//Route::resource('revisores', 'RevisoresController');

Route::prefix('revisores')->group(function () {
    Route::get('/', 'RevisoresController@index')->name('revisores.index');
    Route::get('/{revisore}/validacion', 'RevisoresController@edit')->name('revisores.edit');
    Route::get('/lista-espera', 'RevisoresController@listaEspera')->name('revisores.lista-espera');
});
Route::get('admin', 'Auth\LoginRevisorController@showLoginForm')->middleware('guest');
Route::post('admin/login', 'Auth\LoginRevisorController@login')->name('admin.login');
Route::post('admin/logout', 'Auth\LoginRevisorController@logout')->name('admin.logout');
