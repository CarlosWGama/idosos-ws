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
    Route::group(['prefix' => 'usuarios'], function () {
        Route::post('/alunos', 'Api\UsuariosController@cadastrarAluno');
        Route::get('/alunos', 'Api\UsuariosController@buscarAlunos');
        Route::put('/alunos/{id}', 'Api\UsuariosController@atualizarAluno');
        Route::delete('/alunos/{id}', 'Api\UsuariosController@excluirAluno');
    }); 

});