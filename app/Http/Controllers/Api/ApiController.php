<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Firebase\JWT\JWT;

class ApiController extends Controller {

    protected $areaID = 0;
    //
    /**
     * Recupera o ID do usuário no JWT
     * @param $request | requisição enviada
     * @return int | id do usuário no JWT
     */
    protected function getUsuarioID(Request $request):int {
        $dados = JWT::decode($request->header('Authorization'), config('jwt.senha'), ['HS256']);
        return $dados->id;
    }

    
    /** 
     * Recebe a imagem na base64
     * @param $uriBase64 | Imagem com toda URI data:image/png;base64,
     * @param $nomeArquivo | Qual nome do arquivo para ser salvo
     */
    protected function salvarImagem(string $uriBase64, string $nomeArquivo, string $pasta) {
        $vetor = explode(',', $uriBase64);
        $imagemBase64 = end($vetor);
        file_put_contents(storage_path("app/public/$pasta/$nomeArquivo"), base64_decode($imagemBase64));
    }


    /**
     * Valida o acesso do Usuário ao modulo
     * @param $usuarioID | Id do usuário
     * @param $nivelAcesso | um array com 1 -> Professor | 2 -> Moderador | 3 -> Aluno
     * @return boolean | True -> Acesso liberado | False -> Acesso bloqueado
     */
    protected function validaAcesso(int $usuarioID, array $nivelAcesso = [1, 2]): bool {
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->where('profissao_id', $this->areaID)->firstOrFail();
        //Acesso negado para aluno
        return (in_array($usuario->nivel_acesso, $nivelAcesso));
    }
}
