<?php

namespace App\Http\Controllers\Api;

use App\Models\ExameLaboratorial;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamesLaboratoriaisController extends ApiController {


    //Retorna os exames do paciente   
    public function buscar($pacienteID) {
        $exames = ExameLaboratorial::where('paciente_id', $pacienteID)->get();
        return response()->json(['exames' => $exames], 200);
    }
    
    /** Cadastra  */
    public function cadastrar(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();
        
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID, [1])) return response()->json('Só professor pode cadastrar exame laboratorial', 403);

        $validation = Validator::make($request->exame, [
            'paciente_id'               => 'required|integer',
            'data'                      => 'required', 

            'glicemia_jejum'            => 'integer|nullable',
            'hgt'                       => 'integer|nullable',
            'hemoglobina_glicosilada'   => 'numeric|nullable',
            'colesterol_total'          => 'integer|nullable',
            'hdl'                       => 'integer|nullable',
            'ldl'                       => 'integer|nullable',
            'triglicerideos'            => 'integer|nullable',
            'creatinina_serica'         => 'numeric|nullable',
            'potassio_serico'           => 'numeric|nullable',
            
            'equ_infecccao_urinaria'    => 'integer|nullable',
            'equ_proteinuria'           => 'integer|nullable',
            'equ_corpos_cetonicos'      => 'numeric|nullable',
            'equ_sedimento'             => 'integer|nullable',

            'microalbuminuria'          => 'integer|nullable',
            'proteinuria'               => 'integer|nullable',
            'tsh'                       => 'numeric|nullable',
            'ecg'                       => 'numeric|nullable',
            
            'hematocrito'               => 'numeric|nullable',
            'hemoglobina'               => 'numeric|nullable',
            'vcm'                       => 'numeric|nullable',
            'chcm'                      => 'numeric|nullable',
            'plaquetas'                 => 'integer|nullable',
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->exame;
        $dados['criado_por'] = $usuarioID;
        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        $exame = ExameLaboratorial::create($dados);

        return response()->json($exame, 200);
    }

    /** Atualiza um exame */
    public function atualizar(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID, [1])) return response()->json('Só professor pode aprovar prontuário', 403);

        $exame = ExameLaboratorial::findOrFail($id);

        $validation = Validator::make($request->exame, [
            'data'                      => 'required', 

            'glicemia_jejum'            => 'integer|nullable',
            'hgt'                       => 'integer|nullable',
            'hemoglobina_glicosilada'   => 'numeric|nullable',
            'colesterol_total'          => 'integer|nullable',
            'hdl'                       => 'integer|nullable',
            'ldl'                       => 'integer|nullable',
            'triglicerideos'            => 'integer|nullable',
            'creatinina_serica'         => 'numeric|nullable',
            'potassio_serico'           => 'numeric|nullable',
            
            'equ_infecccao_urinaria'    => 'integer|nullable',
            'equ_proteinuria'           => 'integer|nullable',
            'equ_corpos_cetonicos'      => 'numeric|nullable',
            'equ_sedimento'             => 'integer|nullable',

            'microalbuminuria'          => 'integer|nullable',
            'proteinuria'               => 'integer|nullable',
            'tsh'                       => 'numeric|nullable',
            'ecg'                       => 'numeric|nullable',
            
            'hematocrito'               => 'numeric|nullable',
            'hemoglobina'               => 'numeric|nullable',
            'vcm'                       => 'numeric|nullable',
            'chcm'                      => 'numeric|nullable',
            'plaquetas'                 => 'integer|nullable',
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);


        //Atualiza
        //Remove os campos que não devem ser atualizados por aqui
        $dados = $request->except(['exame.paciente_id', 'exame.id', 'exame.criado_por','exame.criador'])['exame'];
        $dados['modificado_por'] = $usuarioID;
        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        $exame->fill($dados);
        $exame->save();

        return response()->json($exame, 200);
    }

    /**
     * Remove um exame
     * @param $id | id da tarefa
     */
    public function excluir(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID, [1])) return response()->json('Só professor pode remover exame', 403);

      
        $exame = exame::findOrFail($id);
        $exame->delete();
        return response()->json('exame excluído com sucesso', 200);    
    }   
}
