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

/* Route::get('send', function () {
    mail('uncorreomasparapruebas@gmail.com', "orale", "aloooooo");
})->name('send'); */

Auth::routes(['verify' => true]);
Route::get('/register/verify/{code}', 'HomeController@verify');
Route::get('/verify/{code}', 'HomeController@verify');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{code}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Rutas protegidas para Participantes (Asistentes)
Route::group(['middleware' => ['auth:web', 'verified']], function () {
    Route::resource('asistentes', 'AsistenteController')->middleware('own.profile');
    Route::get('/documentos-rechazados', 'AsistenteController@indexRechazados')->name('asistentes.rechazado');
    Route::put('/documentos-rechazados/{asistente}', 'DocumentosController@actualizarDocumentosRechazados')
        ->name('asistentes.actualizarRechazados')
        ->middleware('own.profile');
    Route::get('/credencial-asistente', 'AsistenteController@credencial')->name('asistentes.credencial');
});

// Rutas protegidas para Administradores y Revisores
Route::group(['prefix' => 'revisores', 'middleware' => 'auth:revisor'], function () {
    Route::get('/', 'RevisoresController@index')->name('revisores.index');
    Route::get('/lista-espera', 'RevisoresController@listaEspera')->name('revisores.lista-espera');
    Route::get('/{asistente}/validacion', 'ValidacionesController@edit')->name('validaciones.edit');
    Route::put('/{asistente}', 'ValidacionesController@update')->name('validaciones.update');
    Route::get('/lista-asistentes', 'RevisoresController@listaAsistentes')->name('revisores.lista-asistentes');
    Route::get('/lista-inscritos', 'RevisoresController@listaInscritos')->name('revisores.lista-inscritos');
    Route::get('/inscribir-asistente', 'RevisoresController@createAsistente')->name('revisores.crear-asistente');
    Route::post('/inscribir-asistente', 'RevisoresController@storeAsistente')->name('revisores.guardar-asistente');
    Route::post('/toggle-convocatoria', 'RevisoresController@toggleConvocatoria')->name('revisores.toggle-convocatoria');
    Route::post('/actualizar-mensaje-cierre', 'RevisoresController@actualizarMensajeCierre')->name('revisores.actualizar-mensaje-cierre');
});

// Endpoint seguro de consulta AJAX protegido por guard revisor
Route::get('wsgetuserdata/{userID}', 'RevisoresController@wsGetUserData')
    ->middleware('auth:revisor')
    ->name('revisores.wsgetuserdata');

Route::get('admin', 'Auth\LoginRevisorController@showLoginForm')->middleware('guest:revisor')->name('admin');
Route::post('admin/login', 'Auth\LoginRevisorController@login')->name('admin.login');
Route::post('admin/logout', 'Auth\LoginRevisorController@logout')->name('admin.logout');

