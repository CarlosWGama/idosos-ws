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

    //Casa do Pobre
    Route::group(['prefix' => 'casa'], function () {
        Route::post('agenda', 'Api\CasaDoPobreController@cadastrarEvento');
        Route::delete('agenda/{id}', 'Api\CasaDoPobreController@excluirEvento');
    });

    //Usuarios
    Route::group(['prefix' => 'usuarios'], function () {
        Route::post('/alunos', 'Api\UsuariosController@cadastrarAluno');
        Route::get('/alunos', 'Api\UsuariosController@buscarAlunos');
        Route::put('/alunos/{id}', 'Api\UsuariosController@atualizarAluno');
        Route::delete('/alunos/{id}', 'Api\UsuariosController@excluirAluno');
    });
    
    //Notificações
    Route::group(['prefix' => 'notificacoes'], function () {
        Route::post('/', 'Api\NotificacaoController@cadastrar');
        Route::get('/', 'Api\NotificacaoController@buscarTodas');
        Route::get('/nao-lidas', 'Api\NotificacaoController@totalNaoLidas');
        Route::put('/{id}', 'Api\NotificacaoController@ler');
        Route::delete('/{id}', 'Api\NotificacaoController@excluir');
    });

    //Pacientes
    Route::group(['prefix' => 'pacientes'], function () {
        Route::post('', 'Api\PacientesController@cadastrar');
        Route::put('/{id}', 'Api\PacientesController@atualizar');
        Route::get('{genero?}', 'Api\PacientesController@buscarTodos');
        Route::put('/dados-clinicos/{id}', 'Api\PacientesController@atualizarDadosClinicos');
        Route::get('/dados-clinicos/{id}', 'Api\PacientesController@dadosClinicos');
    });

    //Prontuarios
    Route::group(['prefix' => 'prontuarios'], function () {
        
        //Nutrição
        Route::group(['prefix' => 'nutricao'], function () {
            //Ficha
            Route::get('/ficha/{pacienteID}', 'Api\ProntuarioNutricaoController@buscarFicha');
            Route::put('/ficha', 'Api\ProntuarioNutricaoController@salvarFicha');
            
            //Evoluções
            Route::post('/evolucao', 'Api\ProntuarioNutricaoController@cadastrarEvolucao');
            Route::put('/evolucao/aprovacao/{id}', 'Api\ProntuarioNutricaoController@aprovarEvolucao');
            Route::put('/evolucao/{id}', 'Api\ProntuarioNutricaoController@atualizarEvolucao');
            Route::get('/evolucao/{pacienteID}/{id}/{inicio?}/{limite?}', 'Api\ProntuarioNutricaoController@buscarEvolucoes');
        });

        //Odontologia
        Route::group(['prefix' => 'odontologia'], function () {
            //Ficha
            Route::get('/ficha/{pacienteID}', 'Api\ProntuarioOdontologiaController@buscarFicha');
            Route::put('/ficha', 'Api\ProntuarioOdontologiaController@salvarFicha');
            
            //Evoluções
            Route::post('/evolucao', 'Api\ProntuarioOdontologiaController@cadastrarEvolucao');
            Route::put('/evolucao/aprovacao/{id}', 'Api\ProntuarioOdontologiaController@aprovarEvolucao');
            Route::put('/evolucao/{id}', 'Api\ProntuarioOdontologiaController@atualizarEvolucao');
            Route::get('/evolucao/{pacienteID}/{id}/{inicio?}/{limite?}', 'Api\ProntuarioOdontologiaController@buscarEvolucoes');
        });

        //Fisioterapia
         Route::group(['prefix' => 'fisioterapia'], function () {
            //Ficha
            Route::get('/ficha/{pacienteID}', 'Api\ProntuarioFisioterapiaController@buscarFicha');
            Route::put('/ficha', 'Api\ProntuarioFisioterapiaController@salvarFicha');
            
            //Evoluções
            Route::post('/evolucao', 'Api\ProntuarioFisioterapiaController@cadastrarEvolucao');
            Route::put('/evolucao/aprovacao/{id}', 'Api\ProntuarioFisioterapiaController@aprovarEvolucao');
            Route::put('/evolucao/{id}', 'Api\ProntuarioFisioterapiaController@atualizarEvolucao');
            Route::get('/evolucao/{pacienteID}/{id}/{inicio?}/{limite?}', 'Api\ProntuarioFisioterapiaController@buscarEvolucoes');
        });

         //Educação Física
         Route::group(['prefix' => 'educacao-fisica'], function () {
            //Ficha
            Route::get('/ficha/{pacienteID}', 'Api\ProntuarioEducacaoFisicaController@buscarFicha');
            Route::put('/ficha', 'Api\ProntuarioEducacaoFisicaController@salvarFicha');
            
            //Evoluções
            Route::post('/evolucao', 'Api\ProntuarioEducacaoFisicaController@cadastrarEvolucao');
            Route::put('/evolucao/aprovacao/{id}', 'Api\ProntuarioEducacaoFisicaController@aprovarEvolucao');
            Route::put('/evolucao/{id}', 'Api\ProntuarioEducacaoFisicaController@atualizarEvolucao');
            Route::get('/evolucao/{pacienteID}/{id}/{inicio?}/{limite?}', 'Api\ProntuarioEducacaoFisicaController@buscarEvolucoes');

            //Teste de Acompanhamento
            Route::post('/acompanhamentos', 'Api\ProntuarioEducacaoFisicaController@cadastrarAcompanhamento');
            Route::put('/acompanhamentos/aprovacao/{id}', 'Api\ProntuarioEducacaoFisicaController@aprovarAcompanhamento');
            Route::put('/acompanhamentos/{id}', 'Api\ProntuarioEducacaoFisicaController@atualizarAcompanhamento');
            Route::get('/acompanhamentos/{pacienteID}/{id}/{inicio?}/{limite?}', 'Api\ProntuarioEducacaoFisicaController@buscarAcompanhamentos');
        });

          //Educação Física
          Route::group(['prefix' => 'enfermagem'], function () {
            //Ficha
            Route::get('/ficha/{pacienteID}', 'Api\ProntuarioEnfermagemController@buscarFicha');
            Route::put('/ficha', 'Api\ProntuarioEnfermagemController@salvarFicha');
            
            //Evoluções
            Route::post('/evolucao', 'Api\ProntuarioEnfermagemController@cadastrarEvolucao');
            Route::put('/evolucao/aprovacao/{id}', 'Api\ProntuarioEnfermagemController@aprovarEvolucao');
            Route::put('/evolucao/{id}', 'Api\ProntuarioEnfermagemController@atualizarEvolucao');
            Route::get('/evolucao/{pacienteID}/{id}/{inicio?}/{limite?}', 'Api\ProntuarioEnfermagemController@buscarEvolucoes');

            //Teste de Consulta Clinica
            Route::post('/consulta-clinica', 'Api\ProntuarioEnfermagemController@cadastrarConsultaClinica');
            Route::put('/consulta-clinica/aprovacao/{id}', 'Api\ProntuarioEnfermagemController@aprovarConsultaClinica');
            Route::put('/consulta-clinica/{id}', 'Api\ProntuarioEnfermagemController@atualizarConsultaClinica');
            Route::get('/consulta-clinica/{pacienteID}/{id}/{inicio?}/{limite?}', 'Api\ProntuarioEnfermagemController@buscarConsultasClinicas');
        });
    });

    //Medicamentos
    Route::group(['prefix' => 'medicamentos'], function () {

            Route::get('/ativo/{pacienteID}/{areaID?}', 'Api\MedicamentosController@ativos');
            Route::get('/inativo/{pacienteID}/{areaID?}', 'Api\MedicamentosController@inativos');
            Route::post('', 'Api\MedicamentosController@cadastrar');
            Route::put('/ativacao/{id}/{ativo}', 'Api\MedicamentosController@ativacao');
            Route::put('/{id}', 'Api\MedicamentosController@atualizar');
            Route::delete('/{id}', 'Api\MedicamentosController@excluir');
        
    });

});