<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'tem_filhos'            => 'required|boolean',
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

        //Adiciona a foto
        $paciente->foto = $nomeArquivo = 'paciente_'.$paciente->id.'.png';
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
            'tem_filhos'            => 'required|boolean',
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
        $paciente->save();

        //Adiciona a foto
        if (!empty($request->paciente['foto']) && substr($request->paciente['foto'], 0, 4) == 'data') {
            $nomeArquivo = 'paciente_'.$paciente->id.'.png';
            $this->salvarImagem($request->paciente['foto'], $nomeArquivo, 'pacientes');
        }
        
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
}
