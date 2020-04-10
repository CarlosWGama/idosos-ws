<?php

namespace App\Http\Controllers\Api;

use App\Models\Medicamento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicamentosController extends ApiController {
    

    /** Retorna medicamentos inativos */
    public function inativos(Request $request,  int $pacienteID, int $areaID = null) {
        $modelMedicamento = Medicamento::where('ativo', false)->where('paciente_id', $pacienteID);
        if ($areaID) $modelMedicamento->where('area_id', $areaID);
        $medicamentos = $modelMedicamento->get();
        return response()->json(['medicamentos' => $medicamentos], 200);
    }
    
    /** Retorna medicamentos inativos */
    public function ativos(Request $request, int $pacienteID, int $areaID = null) {
        $modelMedicamento = Medicamento::where('ativo', true)->where('paciente_id', $pacienteID);
        if ($areaID) $modelMedicamento->where('area_id', $areaID);
        $medicamentos = $modelMedicamento->get();
        return response()->json(['medicamentos' => $medicamentos], 200);
    }

    /** Cadastra um novo medicamento */
    public function cadastrar(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();
        
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID, [1])) return response()->json('Só professor pode aprovar prontuário', 403);
        if ($usuario->profissao_id != $request->medicamento['area_id'])  return response()->json('Apenas professor da área pode cadastrar medicamento', 403);


        $validation = Validator::make($request->medicamento, [
            'paciente_id'   => 'required|integer',
            'area_id'       => 'required|integer',
            'descricao'     => 'required', 
            'inicio'        => 'required|date', 
            'tipo'          => 'required|integer', 
            // 'duracao_dias'  => 'required|integer',
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->medicamento;
        $dados['inicio'] = date('Y-m-d', strtotime($dados['inicio']));
        $medicamento = Medicamento::create($dados);

        return response()->json($medicamento, 200);
    }

    /** Atualiza um medicamento */
    public function atualizar(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID, [1])) return response()->json('Só professor pode aprovar prontuário', 403);
        if ($usuario->profissao_id != $request->medicamento['area_id'])  return response()->json('Apenas professor da área pode cadastrar medicamento', 403);

        $medicamento = Medicamento::findOrFail($id);

        $validation = Validator::make($request->medicamento, [
            'paciente_id'   => 'required|integer',
            'area_id'       => 'required|integer',
            'descricao'     => 'required', 
            'inicio'        => 'required|date', 
            'tipo'          => 'required|integer', 
            // 'duracao_dias'  => 'required|integer',
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);


        //Atualiza
        //Remove os campos que não devem ser atualizados por aqui
        $dados = $request->except(['dados.paciente_id', 'dados.id', 'dados.area_id'])['medicamento'];
        
        $dados['inicio'] = date('Y-m-d', strtotime($dados['inicio']));
        $medicamento->fill($dados);
        $medicamento->save();

        return response()->json($medicamento, 200);
    }

    /** Aprova um prontuário */
    public function ativacao(Request $request, int $id, int $ativo) {
        $usuarioID = $this->getUsuarioID($request);
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID, [1])) return response()->json('Só professor pode aprovar prontuário', 403);

        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();
      
        $medicamento = Medicamento::findOrFail($id);
        if ($medicamento->area_id == $usuario->profissao_id || $usuario->admin) {
            $medicamento->ativo = $ativo;
            $medicamento->save();
            return response()->json('Medicamento atualizado com sucesso', 200);
        }
        return response()->json('Não há permissão para deletar medicamento', 403);
    }

    /**
     * Remove um medicamento
     * @param $id | id da tarefa
     */
    public function excluir(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID, [1])) return response()->json('Só professor pode aprovar prontuário', 403);

        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();
      
        $medicamento = Medicamento::findOrFail($id);
        if ($medicamento->area_id == $usuario->profissao_id || $usuario->admin) {
            $medicamento->delete();
            return response()->json('Medicamento excluído com sucesso', 200);
        }
    
        return response()->json('Não há permissão para deletar medicamento', 403);
    }

}
