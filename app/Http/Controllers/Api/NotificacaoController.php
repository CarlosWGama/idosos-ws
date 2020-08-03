<?php

namespace App\Http\Controllers\Api;

use App\Models\Notificacao;
use App\Models\NotificacaoDestinatario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificacaoController extends ApiController {
    
    /** Cadastra uma notificação */
    public function cadastrar(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID)) 
            return response()->json('Para cadastrar paciente, é necessário ser Professor ou Moderador', 403);

        $validation = Validator::make($request->dados, [
            'paciente_id'      => 'required',
            'area_id'          => 'required',
            'descricao'        => 'required'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);
        
        //CRia a notificação
        $notificacao = Notificacao::create([
            'autor_id'      => $usuarioID,
            'paciente_id'   => $request->dados['paciente_id'],
            'descricao'     => $request->dados['descricao']
        ]);

        //Vincula aos usuarios
        $usuarios = Usuario::where('profissao_id', $request->dados['area_id'])->get();
        foreach ($usuarios as $usuario) {
            NotificacaoDestinatario::create([
                'usuario_id'    => $usuario->id,
                'notificacao_id'=> $notificacao->id
            ]);
        }
        
        return response()->json($notificacao, 201);
    } 

    /** Lista quantas notificações o usuário não leu */
    public function totalNaoLidas(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $total = NotificacaoDestinatario::where('lido', false)->where('usuario_id', $usuarioID)->count();
        return response()->json(['total' => $total], 200);
    }

    /** Marca uma notificação como lida */
    public function ler(Request $request, int $notificacaoID) {
        $usuarioID = $this->getUsuarioID($request);
        $notificacao = NotificacaoDestinatario::where('usuario_id', $usuarioID)
                                ->where('notificacao_id', $notificacaoID)
                                ->firstOrFail();
        $notificacao->lido = true;
        $notificacao->save();
        return response()->json(['sucesso' => true], 200);
    }

    /** Deleta uma notificação  */
    public function excluir(Request $request, int $notificacaoID) {
        $usuarioID = $this->getUsuarioID($request);
        $notificacao = NotificacaoDestinatario::where('usuario_id', $usuarioID)
                                ->where('notificacao_id', $notificacaoID)
                                ->firstOrFail();
        $notificacao->delete();
        return response()->json(['sucesso' => true], 200);
    }

    /** Retorna todas notificações de um usuário  */
    public function buscarTodas(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $notificacoes = NotificacaoDestinatario::where('usuario_id', $usuarioID)->get();
        return response()->json(['notificacoes' => $notificacoes], 200);
    }


}
