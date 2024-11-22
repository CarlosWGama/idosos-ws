<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\FotosController;
use App\Http\Controllers\ContatosController;
use App\Http\Controllers\EventosController;
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

Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'index')->name('login'); 
    Route::post('/logar', 'logar')->name('logar');
    Route::get('/logout', 'logout')->name('logout');
});
    
Route::prefix('prefix')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(UsuariosController::class)->prefix('usuarios')->group(function () {
        Route::get('/', 'index')->name('usuarios.listar');
        Route::get('/novo', 'novo')->name('usuarios.novo');
        Route::post('/cadastrar', 'cadastrar')->name('usuarios.cadastrar');
        Route::get('/edicao/{id}', 'edicao')->name('usuarios.edicao');
        Route::post('/editar/{id}', 'editar')->name('usuarios.editar');
        Route::get('/excluir/{id?}', 'excluir')->name('usuarios.excluir');
    });

    Route::prefix('casa-do-pobre')->group(function () {
        //Histórico
        Route::controller(HistoricoController::class)->group(function() {
            Route::get('/historico', 'index')->name('casa.historico');
            Route::post('/historico/editar', 'editar')->name('casa.historico.editar');
        });

        //Fotos
        Route::controller(FotosController::class)->group(function() {
            Route::get('/fotos', 'index')->name('casa.fotos');
            Route::post('/fotos', 'cadastrar')->name('casa.fotos.cadastrar');
            Route::get('/fotos/excluir/{id?}', 'excluir')->name('casa.fotos.excluir');
        });
        
        //Contatos
        Route::controller(ContatosController::class)->prefix('contatos')->group(function () {
            Route::get('/', 'index')->name('contatos.listar');
            Route::get('/novo', 'novo')->name('contatos.novo');
            Route::post('/cadastrar', 'cadastrar')->name('contatos.cadastrar');
            Route::get('/edicao/{id}', 'edicao')->name('contatos.edicao');
            Route::post('/editar/{id}', 'editar')->name('contatos.editar');
            Route::get('/excluir/{id?}', 'excluir')->name('contatos.excluir');
        });


        //Eventos (Agenda)
        Route::controller(EventosController::class)->prefix('eventos')->group(function () {
            Route::get('/', 'index')->name('eventos.listar');
            Route::get('/novo', 'novo')->name('eventos.novo');
            Route::post('/cadastrar', 'cadastrar')->name('eventos.cadastrar');
            Route::get('/edicao/{id}', 'edicao')->name('eventos.edicao');
            Route::post('/editar/{id}', 'editar')->name('eventos.editar');
            Route::get('/excluir/{id?}', 'excluir')->name('eventos.excluir');
        });
    });

});

