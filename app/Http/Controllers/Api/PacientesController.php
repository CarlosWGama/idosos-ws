<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DadosClinicos;
use App\Models\Paciente;
use Illuminate\Support\Facades\Validator;

class PacientesController extends ApiController {
    
    /** Cadastra um Paciente */
    public function cadastrar(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID)) 
            return response()->json('Para cadastrar paciente, é necessário ser Professor ou Moderador', 403);


        $validation = Validator::make($request->paciente, [
            'nome'                  => 'required',
            'data_nascimento'       => 'required|date',
            'masculino'             => 'required|boolean',
            'escolaridade'          => 'required|integer',
            // 'tem_filhos'            => 'required|boolean',
            'estado_civil'          => 'required|integer',
            'frequencia_familiar'   => 'required|integer',
            'data_admissao'         => 'required|date',
            'motivo_admissao'       => 'required|integer',
            'foto'                  => 'required'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);
        
        //Inicia cadastro do idoso
        $paciente = $request->paciente;
        unset($paciente['foto']);
        $paciente['data_nascimento'] = date('Y-m-d', strtotime($paciente['data_nascimento']));
        $paciente['data_admissao'] = date('Y-m-d', strtotime($paciente['data_admissao']));
        $paciente = Paciente::create($paciente);

        //Cria Dados Clinicos Gerais
        $dadosClinicos = DadosClinicos::create(['paciente_id' => $paciente->id]);
        $dadosClinicos->condicoesClinicas()->sync([1]); //Sem condições clinicas diferentes

        //Adiciona a foto
        $paciente->foto = $nomeArquivo = 'paciente_'.$paciente->id.'.jpg';
        $this->salvarImagem($request->paciente['foto'], $nomeArquivo, 'pacientes');
        $paciente->save();
        
        return response()->json($paciente, 201);
    }
    
    /** Atualizar */
    public function atualizar(Request $request, int $pacienteID) {
        $usuarioID = $this->getUsuarioID($request);
    
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID)) 
          return response()->json('Para atualizar paciente, é necessário ser Professor ou Moderador', 403);


        $validation = Validator::make($request->paciente, [
            'nome'                  => 'required',
            'data_nascimento'       => 'required|date',
            'masculino'             => 'required|boolean',
            'escolaridade'          => 'required|integer',
            // 'tem_filhos'            => 'required|boolean',
            'estado_civil'          => 'required|integer',
            'frequencia_familiar'   => 'required|integer',
            'data_admissao'         => 'required|date',
            'motivo_admissao'       => 'required|integer'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);
        
        //Inicia cadastro do idoso
        //Inicia cadastro do idoso
        $dados = $request->paciente;
        unset($dados['foto']);
        $dados['data_nascimento'] = date('Y-m-d', strtotime($dados['data_nascimento']));
        $dados['data_admissao'] = date('Y-m-d', strtotime($dados['data_admissao']));
        $paciente = Paciente::findOrFail($pacienteID);
        $paciente->fill($dados);

        //Adiciona a foto
        if (!empty($request->paciente['foto']) && substr($request->paciente['foto'], 0, 4) == 'data') {
            $paciente->foto = $nomeArquivo = 'paciente_'.$paciente->id.'.jpg';
            $this->salvarImagem($request->paciente['foto'], $nomeArquivo, 'pacientes');
        }
        
        $paciente->save();
        
        return response()->json($paciente, 200);
    }

    /**
     * Busca todos os pacientes
     * @param $genero int | 0 - Idosas | 1 - Idosos | 2 - Todos
     */
    public function buscarTodos(int $genero = 2) {
        $pacientes = [];
        if ($genero == 2) //Busca todos
            $pacientes = Paciente::all();
        elseif ($genero == 1) //Masculino
            $pacientes = Paciente::where('masculino', true)->get();
        else // Feminino
            $pacientes = Paciente::where('masculino', false)->get();
        
        return response()->json(['pacientes' => $pacientes], 200);
    }
    
    /** Busca um paciente pelo ID */
    public function buscar($pacienteID) {
        $paciente = Paciente::findOrFail($pacienteID);
        
        return response()->json(['paciente' => $paciente], 200);
    }

    /**
     * Atualiza os dados clinicos de um paciente 
     */ 
    public function atualizarDadosClinicos(Request $request, int $pacienteID) {
        $usuarioID = $this->getUsuarioID($request);
    
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID)) 
          return response()->json('Para atualizar os dados clínicos dos paciente, é necessário ser Professor ou Moderador', 403);

        $validation = Validator::make($request->dados, [
            'condicoes_clinicas'        => 'required',
            'plano'                     => 'required',
            'cartao_sus'                => 'required',
            'fumante'                   => 'required',
            'fumante_idade'             => 'nullable|integer',
            'fumante_media_cigarros'    => 'nullable|integer',
            'etilista'                  => 'required|integer',
            'sono'                      => 'required|integer',
            'protese_dentaria'          => 'required|boolean',
            'medicamento_continuo'      => 'required|boolean',
            'medicamento_fornecimento'  => 'required|integer',
            'queda'                     => 'required|integer',
            'dispositivo_andar'         => 'required|integer',
            'medicamento_continuo'      => 'required|boolean',
            'atividade_recreativa'      => 'required|boolean',
            'cf_banhar'                 => 'required|integer',
            'cf_vestir'                 => 'required|integer',
            'cf_uso_banheiro'           => 'required|integer',
            'cf_transferir'             => 'required|integer',
            'cf_continencia'            => 'required|integer',
            'cf_alimentar'              => 'required|integer'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        $dados = $request->except(['dados.paciente_id', 'dados.id'])['dados'];
        $dadosClinicos = DadosClinicos::where('paciente_id', $pacienteID)->firstOrFail();

        //Condições clinicas
        $dadosClinicos->condicoesClinicas()->sync($dados['condicoes_clinicas']); //Remove todas condições clinicas
        unset($dados['condicoes_clinicas']);

        $dadosClinicos->fill($dados);
        
        $dadosClinicos->save();
        return response()->json($dadosClinicos, 200);

    }

    /** Recupera dados clínicos gerais do paciente */
    public function dadosClinicos(int $pacienteID) {
        $dados = DadosClinicos::where('paciente_id', $pacienteID)->firstOrFail();
        return response()->json(['dados' => $dados], 200);
    }
}
