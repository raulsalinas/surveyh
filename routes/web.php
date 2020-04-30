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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::get('survey', ['as' => 'survey.menu', 'uses' => 'EncuestaController@index']);
	Route::get('survey-form/{tipo}', ['as' => 'survey.form', 'uses' => 'EncuestaController@survey_form']);
	Route::get('get_user', 'EncuestaController@get_user');	
	Route::post('guardar_respuesta', 'EncuestaController@guardar_respuesta');	
	Route::get('refresh_preguntas_usuario', 'EncuestaController@refresh_preguntas_usuario');	
	Route::get('procentaje_avance_encuesta/{idtipo}', 'EncuestaController@procentaje_avance_encuesta');	
	Route::get('configuracion/pregunta', ['as' => 'configuracion.pregunta', 'uses' => 'ConfiguracionController@configuracion_pregunta_index']);
	Route::get('configuracion/tipo_encuesta', ['as' => 'configuracion.tipo_encuesta', 'uses' => 'ConfiguracionController@configuracion_tipo_encuesta_index']);
	Route::get('configuracion/periodo', ['as' => 'configuracion.periodo', 'uses' => 'ConfiguracionController@configuracion_periodo_index']);

	Route::get('get_pregunta', 'ConfiguracionController@get_pregunta');	
	Route::get('get_pregunta/{id}', 'ConfiguracionController@get_pregunta_by_id');	
	Route::post('guardar_pregunta', 'ConfiguracionController@guardar_pregunta');	
	Route::put('actualizar_pregunta', 'ConfiguracionController@actualizar_pregunta');	
	Route::delete('eliminar_pregunta/{id}', 'ConfiguracionController@eliminar_pregunta');	
	Route::get('get_tipo_encuesta', 'ConfiguracionController@get_tipo_encuesta');	
	Route::get('get_tipo_encuesta/{id}', 'ConfiguracionController@get_tipo_encuesta_by_id');	
	Route::put('actualizar_tipo_encuesta', 'ConfiguracionController@actualizar_tipo_encuesta');	
	
	Route::get('get_periodo', 'ConfiguracionController@get_periodo');	
	Route::post('guardar_periodo', 'ConfiguracionController@guardar_periodo');	
	Route::get('get_periodo/{id}', 'ConfiguracionController@get_periodo_by_id');	
	Route::put('actualizar_periodo', 'ConfiguracionController@actualizar_periodo');	
	Route::delete('eliminar_periodo/{id}', 'ConfiguracionController@eliminar_periodo');	

	Route::get('get_cantidad_encuestas_empezadas', 'DashboardController@get_cantidad_encuestas_empezadas');	
	Route::get('get_cantidad_encuestas_completadas', 'DashboardController@get_cantidad_encuestas_completadas');	
	Route::get('get_cantidad_usuarios', 'DashboardController@get_cantidad_usuarios');	
	Route::get('get_encuestas_satisfacion_comenzadas_mensual', 'DashboardController@get_encuestas_satisfacion_comenzadas_mensual');	
	Route::get('get_encuestas_liderazgo_comenzadas_mensual', 'DashboardController@get_encuestas_liderazgo_comenzadas_mensual');	
	Route::get('get_avance_encuestas_liderazgo', 'DashboardController@get_avance_encuestas_liderazgo');	
	Route::get('get_avance_encuestas_satisfaccion', 'DashboardController@get_avance_encuestas_satisfaccion');	
	
	
	Route::get('reportes', ['as' => 'reportes.indice', 'uses' => 'ReportesController@index']);
	Route::get('reporte_respuesta_periodo_actual', 'ReportesController@reporte_respuesta_periodo_actual');	


});

