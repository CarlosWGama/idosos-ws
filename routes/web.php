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


Route::get('/', function() { return redirect()->route('login'); });

Route::get('/login', 'LoginController@index')->name('login');
Route::post('/logar', 'LoginController@logar')->name('logar');
Route::get('/logout', 'LoginController@logout')->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::group(['prefix' => 'usuarios'], function () {
        Route::get('/', 'UsuariosController@index')->name('usuarios.listar');
        Route::get('/novo', 'UsuariosController@novo')->name('usuarios.novo');
        Route::post('/cadastrar', 'UsuariosController@cadastrar')->name('usuarios.cadastrar');
        Route::get('/edicao/{id}', 'UsuariosController@edicao')->name('usuarios.edicao');
        Route::post('/editar/{id}', 'UsuariosController@editar')->name('usuarios.editar');
        Route::get('/excluir/{id?}', 'UsuariosController@excluir')->name('usuarios.excluir');
    });

    Route::group(['prefix' => 'casa-do-pobre'], function () {
        //Histórico
        Route::get('/historico', 'HistoricoController@index')->name('casa.historico');
        Route::post('/historico/editar', 'HistoricoController@editar')->name('casa.historico.editar');
        
        //Fotos
        Route::get('/fotos', 'FotosController@index')->name('casa.fotos');
        Route::post('/fotos', 'FotosController@cadastrar')->name('casa.fotos.cadastrar');
        Route::get('/fotos/excluir/{id?}', 'FotosController@excluir')->name('casa.fotos.excluir');

        //Contatos
        Route::group(['prefix' => 'contatos'], function () {
            Route::get('/', 'ContatosController@index')->name('contatos.listar');
            Route::get('/novo', 'ContatosController@novo')->name('contatos.novo');
            Route::post('/cadastrar', 'ContatosController@cadastrar')->name('contatos.cadastrar');
            Route::get('/edicao/{id}', 'ContatosController@edicao')->name('contatos.edicao');
            Route::post('/editar/{id}', 'ContatosController@editar')->name('contatos.editar');
            Route::get('/excluir/{id?}', 'ContatosController@excluir')->name('contatos.excluir');
        });
    });

});

