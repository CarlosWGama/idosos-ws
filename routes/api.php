<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/usuarios', 'Api\UsuariosController@registrar');
Route::post('/login', 'Api\UsuariosController@logar');


Route::group(['prefix' => 'casa'], function () {
    Route::get('historico', 'Api\CasaDoPobreController@historico');
    Route::get('fotos', 'Api\CasaDoPobreController@fotos');
    Route::get('agenda', 'Api\CasaDoPobreController@agenda');
    Route::get('contatos', 'Api\CasaDoPobreController@contatos');
    Route::get('equipe', 'Api\CasaDoPobreController@equipe');
});

Route::group(['middleware' => ['jwt']], function () {   
    // Route::group(['prefix' => 'tarefas'], function () {
    //     Route::post('/', 'Api\TarefasController@cadastrar');
    //     Route::get('/', 'Api\TarefasController@listar');
    //     Route::get('/{id}', 'Api\TarefasController@buscar');
    //     Route::put('/{id}', 'Api\TarefasController@atualizar');
    //     Route::delete('/{id}', 'Api\TarefasController@remover');
    // }); 

});