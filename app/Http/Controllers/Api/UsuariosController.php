<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use Firebase\JWT\JWT;

/**
 * @package API
 * Classe responsável por Controlar as requisições da API envolvendo usuário
 */
class UsuariosController extends ApiController {
    
    /** Loga o usuário */
    public function logar(Request $request) {
        $usuario = Usuario::where('id', $request->codigo)
                            ->where('senha', md5($request->senha))
                            ->where('deletado', false)
                            ->firstOrFail(); //Senão achar retorna 404

        $jwt = JWT::encode(['id' => $usuario->id], config('jwt.senha'), 'HS256');
        return response()->json(['jwt' => $jwt, 'usuario' => $usuario], 200);
    }

    /** Cadastra um aluno */
    public function cadastrarAluno(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $professor = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        $validation = Validator::make($request->aluno, [
            'nome'          => 'required',
            'senha'         => 'required|min:4',
            'nivel_acesso'  => 'required|integer'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);
        
        //Inicio cadastro do aluno
        $aluno = $request->aluno;
        $aluno['senha'] = md5($aluno['senha']);
        $aluno['professor_id'] = $professor->id;
        $aluno['profissao_id'] = $professor->profissao_id;

        //Salva o aluno
        $aluno = Usuario::create($aluno);
        
        return response()->json($aluno, 201);
    }  

    /** Atualizar um aluno
     * @param $id id do Aluno
     */
    public function atualizarAluno(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        
        $validation = Validator::make($request->aluno, [
            'nome'           => 'required',
            'nivel_acesso'   => 'required|integer',
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);
        
        //Atualiza
        $dados = $request->aluno;
        if (empty($dados['senha'])) unset($dados['senha']);
        else $dados['senha'] = md5($dados['senha']);
        
        $aluno = Usuario::where('id', $id)->where('deletado', false)->where('professor_id', $usuarioID)->firstOrFail();
        $aluno->fill($dados);
        $aluno->save();

        return response()->json($aluno, 200);
    }  

    /** Busca os alunos daquele professor */
    public function buscarAlunos(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $alunos =  Usuario::where('professor_id', $usuarioID)->where('deletado', false)->get();
        return response()->json(['alunos' => $alunos], 201);
    }

    /**
     * Remove uma Tarefa do sistema
     * @param $id | id da tarefa
     */
    public function excluirAluno(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('professor_id', $usuarioID)->where('id', $id)->where('deletado', false)->firstOrFail();
        $usuario->deletado = true;
        $usuario->save();
        return response()->json('Aluno excluído com sucesso', 200);
    }
}
