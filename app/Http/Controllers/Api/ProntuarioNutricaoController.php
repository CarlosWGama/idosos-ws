<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\NutProntuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;

class ProntuarioNutricaoController extends ApiController {

    /** Retorna todos os prontuarios */
    public function buscarTodos(Request $request) {
        $prontuarios = NutProntuario::with('usuario')->orderBy('data', 'desc')->get();
        return response()->json(['prontuarios' => $prontuarios], 200);
    }

    /** Retorna o ultimo prontuário aprovado */
    public function buscarFicha() {
        $prontuario = NutProntuario::where('aprovado', true)->orderBy('id', 'desc')->first();
        return response()->json(['prontuario' => $prontuario], 200);
    }

    /**Retorna um prontuário de nutrição pelo ID */
    public function buscar(int $id) {
        $prontuario = NutProntuario::findOrFail($id);
        return response()->json(['prontuario' => $prontuario], 200);
    }

    /** Cadastra um novo prontuário */
    public function cadastrar(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
    
        $validation = Validator::make($request->dados, [
            'paciente_id'                   => 'required',
            'data'                          => 'required',
            'habito_intestinal_dia'         => 'integer', 
            'habito_intestinal_semana'      => 'integer', 
            'consistencia_fezes'            => 'required|integer', 
            'laxante'                       => 'required|boolean',
            'apetite'                       => 'required|integer',
            'sobra_comida'                  => 'required|integer',
            'sede'                          => 'required|boolean',
            'liquidos_diarios'              => 'required|integer',
            'liquido_consumo'               => 'required|integer',
            'suplemento'                    => 'required|boolean',
            //Antroometria
            'peso_atual'                    => 'required|numeric', 
            'peso_usual'                    => 'required|numeric',
            'peso_estimado'                 => 'required|numeric', 
            'perda_peso'                    => 'required|numeric',
            'altura'                        => 'required|numeric',
            'altura_joelho'                 => 'required|numeric',
            'semi_envergadura'              => 'required|numeric',
            'altura_estimada'               => 'required|numeric', 
            'imc'                           => 'required|numeric', 
            'circunferencia_panturrilha'    => 'required|numeric', 
            'circunferencia_braco'          => 'required|numeric',
            'circunferencia_pulso'          => 'required|numeric', 
            'dct'                           => 'required|numeric',
            'dcse'                          => 'required|numeric', 
            'circunferencia_muscular_braco' => 'required|numeric',
            'circunferencia_cintura'        => 'required|numeric', 
            'circunferencia_cintura_tipo'   => 'required|integer', 
            'marcapasso'                    => 'required|boolean',
            'edema'                         => 'required|boolean',
            'cacifo'                        => 'required|boolean',
            'lado_dominante'                => 'required|integer',
            //Avalição força palmar
            'fp_mao_direita1'               => 'required|numeric',
            'fp_mao_direita2'               => 'required|numeric',
            'fp_mao_direita3'               => 'required|numeric',
            'fp_mao_esquerda1'              => 'required|numeric',
            'fp_mao_esquerda2'              => 'required|numeric',
            'fp_mao_esquerda3'              => 'required|numeric',
            //Exame física
            'c_consumo_musculo_temporal'    => 'required|boolean',
            'c_consumo_bola_gordurosa'      => 'required|boolean',
            'c_arco_zigomatico_aparente'    => 'required|boolean',
            'c_depressao_masseter'          => 'required|boolean',
            't_clavicula_aparente'          => 'required|boolean',
            't_esterno_aparente'            => 'required|boolean',
            't_ombros_quadrados'            => 'required|boolean',
            'p_proeminência_supra_infra'    => 'required|boolean',
            'o_esclerotica'                 => 'required|boolean',
            'o_mucosa_hipocoradas'          => 'required|boolean',
            'o_orbitas_profundas'           => 'required|boolean',
            'cf_coloracao_mucosa'           => 'required|integer',
            'ms_edema'                      => 'required|boolean',
            'mi_edema'                      => 'required|boolean',
            'mi_joelho_quadrado'            => 'required|boolean',
            'pele_manchas'                  => 'required|boolean',
            'pele_ressecamento'             => 'required|boolean',
            'pele_lesoes'                   => 'required|boolean',
            'pele_turgor'                   => 'required|boolean',
            'pele_prurido'                  => 'required|boolean',
            'diagnostico'                   => 'required',
            'objetivos'                     => 'required',
            'conduta'                       => 'required'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->except(['dados.saude_gastrointestinal', 'dados.membro_amputado'])['dados'];
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        $dados['usuario_id'] = $usuarioID;
        $dados['aprovado'] = $usuario->nivel_acesso == 1;

        $prontuario = NutProntuario::create($dados);

        //Saude Gastroinstestinal
        $prontuario->saudeGastrointestinal()->sync($request->dados['saude_gastrointestinal']); 
        //Membro amputado
        $prontuario->membroAmputado()->sync($request->dados['membro_amputado']);

        $prontuario->save();
        return response()->json($prontuario, 200);
    }

    /** Atualiza um prontuário */
    public function atualizar(Request $request, int $id) {
        
        $usuarioID = $this->getUsuarioID($request);
        
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();
        $prontuario = NutProntuario::findOrFail($id);
        
        //Avalia se é o Dono do Prontuário ou um Professor/Moderador
        if (!in_array($usuario->nivel_acesso, [1, 2]) && $prontuario->usuario_id != $usuarioID)
            return response()->json('Apenas o dono do prontuário ou um professor/moderador pode editar esse prontuário', 403);
        
        $validation = Validator::make($request->dados, [
            'data'                          => 'required',
            'consistencia_fezes'            => 'required|integer', 
            'laxante'                       => 'required|boolean',
            'apetite'                       => 'required|integer',
            'sobra_comida'                  => 'required|integer',
            'sede'                          => 'required|boolean',
            'liquidos_diarios'              => 'required|integer',
            'liquido_consumo'               => 'required|integer',
            'suplemento'                    => 'required|boolean',
            //Antroometria
            'peso_atual'                    => 'required', 
            'peso_usual'                    => 'required',
            'peso_estimado'                 => 'required', 
            'perda_peso'                    => 'required',
            'altura'                        =>'required',
            'altura_joelho'                 => 'required',
            'semi_envergadura'              => 'required',
            'altura_estimada'               => 'required', 
            'imc'                           => 'required', 
            'circunferencia_panturrilha'    => 'required', 
            'circunferencia_braco'          => 'required',
            'circunferencia_pulso'          => 'required', 
            'dct'                           => 'required',
            'dcse'                          => 'required', 
            'circunferencia_muscular_braco' => 'required',
            'circunferencia_cintura'        => 'required', 
            'circunferencia_cintura_tipo'   => 'required|integer', 
            'marcapasso'                    => 'required|boolean',
            'edema'                         => 'required|boolean',
            'cacifo'                        => 'required|boolean',
            'lado_dominante'                => 'required|integer',
            //Avalição força palmar
            'fp_mao_direita1'               => 'required|integer',
            'fp_mao_direita2'               => 'required|integer',
            'fp_mao_direita3'               => 'required|integer',
            'fp_mao_esquerda1'              => 'required|integer',
            'fp_mao_esquerda2'              => 'required|integer',
            'fp_mao_esquerda3'              => 'required|integer',
            //Exame física
            'c_consumo_musculo_temporal'    => 'required|boolean',
            'c_consumo_bola_gordurosa'      => 'required|boolean',
            'c_arco_zigomatico_aparente'    => 'required|boolean',
            'c_depressao_masseter'          => 'required|boolean',
            't_clavicula_aparente'          => 'required|boolean',
            't_esterno_aparente'            => 'required|boolean',
            't_ombros_quadrados'            => 'required|boolean',
            'p_proeminência_supra_infra'    => 'required|boolean',
            'o_esclerotica'                 => 'required|boolean',
            'o_mucosa_hipocoradas'          => 'required|boolean',
            'o_orbitas_profundas'           => 'required|boolean',
            'cf_coloracao_mucosa'           => 'required|integer',
            'ms_edema'                      => 'required|boolean',
            'mi_edema'                      => 'required|boolean',
            'mi_joelho_quadrado'            => 'required|boolean',
            'pele_manchas'                  => 'required|boolean',
            'pele_ressecamento'             => 'required|boolean',
            'pele_lesoes'                   => 'required|boolean',
            'pele_turgor'                   => 'required|boolean',
            'pele_prurido'                  => 'required|boolean',
            'diagnostico'                   => 'required',
            'objetivos'                     => 'required',
            'conduta'                       => 'required'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);


        //Atualiza
        //Remove os campos que não devem ser atualizados por aqui
        $dados = $request->except(['dados.paciente_id', 'dados.id', 'dados.usuario_id', 'dados.aprovado'])['dados'];
        
        $dados['data'] = date('Y-m-d', strtotime($dados['data']));

        //Saude Gastroinstestinal
        $prontuario->saudeGastrointestinal()->sync($dados['saude_gastrointestinal']); 
        //Membro amputado
        $prontuario->membroAmputado()->sync($dados['membro_amputado']);
        unset($dados['saude_gastrointestinal']);
        unset($dados['membro_amputado']);

        $prontuario->fill($dados);

        $prontuario->save();
        return response()->json($prontuario, 200);
    }

    /** Aprova um prontuário */
    public function aprovar(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID, [1])) 
            return response()->json('Só professor pode aprovar prontuário', 403);
    
        $prontuario = NutProntuario::with('usuario')->where('id', $id)->firstOrFail();
        if ($prontuario->usuario->professor_id != $usuarioID)
            return response()->json('Apenas o professor do aluno pode aprovar seu prontuário', 403);
        
        $prontuario->aprovado = true;
        $prontuario->save();

        return response()->json('Atualizado com sucesso', 200);

    }


}
