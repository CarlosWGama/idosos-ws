<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UsuariosController;
use App\Http\Controllers\Api\CasaDoPobreController;
use App\Http\Controllers\Api\NotificacaoController;
use App\Http\Controllers\Api\PacientesController;
use App\Http\Controllers\Api\EstoqueFarmacia;
use App\Http\Controllers\Api\ProntuarioNutricaoController;
use App\Http\Controllers\Api\ProntuarioOdontologiaController;
use App\Http\Controllers\Api\ProntuarioFisioterapiaController;
use App\Http\Controllers\Api\ProntuarioEducacaoFisicaController;
use App\Http\Controllers\Api\ProntuarioEnfermagemController;
use App\Http\Controllers\Api\MedicamentosController;
use App\Http\Controllers\Api\ExamesLaboratoriaisController;
use App\Models\Notificacao;

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

Route::post('/usuarios', [UsuariosController::class, 'registar']);
Route::post('/login', [UsuariosController::class, 'logar']);


Route::controller(CasaDoPobreController::class)->prefix('casa')->group(function () {
    Route::get('historico', 'historico');
    Route::get('fotos', 'fotos');
    Route::get('agenda', 'agenda');
    Route::get('contatos', 'contatos');
    Route::get('equipe', 'equipe');
});

Route::controller(NotificacaoController::class)->middleware('jwt')->group(function () {   

    //Casa do Pobre
    Route::controller(CasaDoPobreController::class)->prefix('casa')->group(function () {
        Route::post('agenda', 'cadastrarEvento');
        Route::delete('agenda/{id}', 'excluirEvento');
    });

    //Usuarios
    Route::controller(UsuariosController::class)->prefix('usuarios')->group(function () {
        Route::post('/alunos', 'cadastrarAluno');
        Route::get('/alunos', 'buscarAlunos');
        Route::put('/alunos/{id}', 'atualizarAluno');
        Route::delete('/alunos/{id}', 'excluirAluno');
    });
    
    //Notificações
    Route::controller(NotificacaoController::class)->prefix('notificacoes')->group(function () {
        Route::post('/', 'cadastrar');
        Route::get('/', 'buscarTodas');
        Route::get('/nao-lidas', 'totalNaoLidas');
        Route::put('/{id}', 'ler');
        Route::delete('/{id}', 'excluir');
    });

    //Pacientes
    Route::controller(PacientesController::class)->prefix('pacientes')->group(function () {
        Route::post('', 'cadastrar');
        Route::put('/{id}', 'atualizar');
        Route::get('{genero?}', 'buscarTodos');
        Route::put('/dados-clinicos/{id}', 'atualizarDadosClinicos');
        Route::get('/dados-clinicos/{id}', 'dadosClinicos');
    });

    //Estoque
    Route::controller(EstoqueFarmacia::class)->prefix('estoque')->group(function () {
        Route::get('/{tipo}/{inicio?}/{limite?}', 'buscar');
        Route::post('/{tipo}', 'cadastrar');
        Route::put('/{tipo}/{id}', 'atualizar');
        Route::delete('/{tipo}/{id}', 'excluir');
    });

    //Prontuarios
    Route::prefix('prontuarios')->group(function () {
        
        //Nutrição
        Route::controller(ProntuarioNutricaoController::class)->prefix('nutricao')->group(function () {
            //Ficha
            Route::get('/ficha/{pacienteID}', 'buscarFicha');
            Route::put('/ficha', 'salvarFicha');
            
            //Evoluções
            Route::post('/evolucao', 'cadastrarEvolucao');
            Route::put('/evolucao/aprovacao/{id}', 'aprovarEvolucao');
            Route::put('/evolucao/{id}', 'atualizarEvolucao');
            Route::get('/evolucao/{pacienteID}/{id}/{inicio?}/{limite?}', 'buscarEvolucoes');
        });

        //Odontologia
        Route::controller(ProntuarioOdontologiaController::class)->prefix('odontologia')->group(function () {
            //Ficha
            Route::get('/ficha/{pacienteID}', 'buscarFicha');
            Route::put('/ficha', 'salvarFicha');
            
            //Evoluções
            Route::post('/evolucao', 'cadastrarEvolucao');
            Route::put('/evolucao/aprovacao/{id}', 'aprovarEvolucao');
            Route::put('/evolucao/{id}', 'atualizarEvolucao');
            Route::get('/evolucao/{pacienteID}/{id}/{inicio?}/{limite?}', 'buscarEvolucoes');
        });

        //Fisioterapia
         Route::controller(ProntuarioFisioterapiaController::class)->prefix('fisioterapia')->group(function () {
            //Ficha
            Route::get('/ficha/{pacienteID}', 'buscarFicha');
            Route::put('/ficha', 'salvarFicha');
            
            //Evoluções
            Route::post('/evolucao', 'cadastrarEvolucao');
            Route::put('/evolucao/aprovacao/{id}', 'aprovarEvolucao');
            Route::put('/evolucao/{id}', 'atualizarEvolucao');
            Route::get('/evolucao/{pacienteID}/{id}/{inicio?}/{limite?}', 'buscarEvolucoes');
        });

         //Educação Física
         Route::controller(ProntuarioEducacaoFisicaController::class)->prefix('educacao-fisica')->group(function () {
            //Ficha
            Route::get('/ficha/{pacienteID}', 'buscarFicha');
            Route::put('/ficha', 'salvarFicha');
            
            //Evoluções
            Route::post('/evolucao', 'cadastrarEvolucao');
            Route::put('/evolucao/aprovacao/{id}', 'aprovarEvolucao');
            Route::put('/evolucao/{id}', 'atualizarEvolucao');
            Route::get('/evolucao/{pacienteID}/{id}/{inicio?}/{limite?}', 'buscarEvolucoes');

            //Teste de Acompanhamento
            Route::post('/acompanhamentos', 'cadastrarAcompanhamento');
            Route::put('/acompanhamentos/aprovacao/{id}', 'aprovarAcompanhamento');
            Route::put('/acompanhamentos/{id}', 'atualizarAcompanhamento');
            Route::get('/acompanhamentos/{pacienteID}/{id}/{inicio?}/{limite?}', 'buscarAcompanhamentos');
        });

          //Educação Física
          Route::controller(ProntuarioEnfermagemController::class)->prefix('enfermagem')->group(function () {
            //Ficha
            Route::get('/ficha/{pacienteID}', 'buscarFicha');
            Route::put('/ficha', 'salvarFicha');
            
            //Evoluções
            Route::post('/evolucao', 'cadastrarEvolucao');
            Route::put('/evolucao/aprovacao/{id}', 'aprovarEvolucao');
            Route::put('/evolucao/{id}', 'atualizarEvolucao');
            Route::get('/evolucao/{pacienteID}/{id}/{inicio?}/{limite?}', 'buscarEvolucoes');

            //Teste de Consulta Clinica
            Route::post('/consulta-clinica', 'cadastrarConsultaClinica');
            Route::put('/consulta-clinica/aprovacao/{id}', 'aprovarConsultaClinica');
            Route::put('/consulta-clinica/{id}', 'atualizarConsultaClinica');
            Route::get('/consulta-clinica/{pacienteID}/{id}/{inicio?}/{limite?}', 'buscarConsultasClinicas');
        });
    });

    //Medicamentos
    Route::controller(MedicamentosController::class)->prefix('medicamentos')->group(function () {

            Route::get('/ativo/{pacienteID}/{areaID?}', 'ativos');
            Route::get('/inativo/{pacienteID}/{areaID?}', 'inativos');
            Route::post('', 'cadastrar');
            Route::put('/ativacao/{id}/{ativo}', 'ativacao');
            Route::put('/{id}', 'atualizar');
            Route::delete('/{id}', 'excluir');
        
    });
    
    //Exames Laboratoriais
    Route::controller(ExamesLaboratoriaisController::class)->prefix('exames-laboratoriais')->group(function () {
            Route::get('/{pacienteID}', 'buscar');
            Route::post('', 'cadastrar');
            Route::put('/{id}', 'atualizar');
            Route::delete('/{id}', 'excluir');
    });

});