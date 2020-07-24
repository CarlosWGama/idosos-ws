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
            'habito_intestinal_dia'         => 'integer|nullable', 
            'habito_intestinal_semana'      => 'integer|nullable', 
            'consistencia_fezes'            => 'integer|nullable', 
            'laxante'                       => 'boolean',
            'apetite'                       => 'integer|nullable',
            'sobra_comida'                  => 'integer|nullable',
            'sede'                          => 'boolean',
            'liquidos_diarios'              => 'integer|nullable',
            'liquido_consumo'               => 'integer|nullable',
            'suplemento'                    => 'boolean',
            //Antroometria
            'peso_atual'                    => 'numeric|nullable', 
            'peso_usual'                    => 'numeric|nullable',
            'peso_estimado'                 => 'numeric|nullable', 
            'perda_peso'                    => 'numeric|nullable',
            'altura'                        => 'numeric|nullable',
            'altura_joelho'                 => 'numeric|nullable',
            'semi_envergadura'              => 'numeric|nullable',
            'altura_estimada'               => 'numeric|nullable', 
            'imc'                           => 'numeric|nullable', 
            'circunferencia_panturrilha'    => 'numeric|nullable', 
            'circunferencia_braco'          => 'numeric|nullable',
            'circunferencia_pulso'          => 'numeric|nullable', 
            'dct'                           => 'numeric|nullable',
            'dcse'                          => 'numeric|nullable', 
            'circunferencia_muscular_braco' => 'numeric|nullable',
            'circunferencia_cintura'        => 'numeric|nullable', 
            'circunferencia_cintura_tipo'   => 'integer|nullable', 
            'marcapasso'                    => 'boolean',
            'edema'                         => 'boolean',
            'cacifo'                        => 'boolean',
            'lado_dominante'                => 'integer|nullable',
            //Avalição força palmar
            'fp_mao_direita1'               => 'numeric|nullable',
            'fp_mao_direita2'               => 'numeric|nullable',
            'fp_mao_direita3'               => 'numeric|nullable',
            'fp_mao_esquerda1'              => 'numeric|nullable',
            'fp_mao_esquerda2'              => 'numeric|nullable',
            'fp_mao_esquerda3'              => 'numeric|nullable',
            //Exame física
            'c_consumo_musculo_temporal'    => 'boolean',
            'c_consumo_bola_gordurosa'      => 'boolean',
            'c_arco_zigomatico_aparente'    => 'boolean',
            'c_depressao_masseter'          => 'boolean',
            't_clavicula_aparente'          => 'boolean',
            't_esterno_aparente'            => 'boolean',
            't_ombros_quadrados'            => 'boolean',
            'p_proeminência_supra_infra'    => 'boolean',
            'o_esclerotica'                 => 'boolean',
            'o_mucosa_hipocoradas'          => 'boolean',
            'o_orbitas_profundas'           => 'boolean',
            'cf_coloracao_mucosa'           => 'integer|nullable',
            'ms_edema'                      => 'boolean',
            'mi_edema'                      => 'boolean',
            'mi_joelho_quadrado'            => 'boolean',
            'pele_manchas'                  => 'boolean',
            'pele_ressecamento'             => 'boolean',
            'pele_lesoes'                   => 'boolean',
            'pele_turgor'                   => 'boolean',
            'pele_prurido'                  => 'boolean',
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
            'consistencia_fezes'            => 'integer|nullable', 
            'laxante'                       => 'boolean',
            'apetite'                       => 'integer|nullable',
            'sobra_comida'                  => 'integer|nullable',
            'sede'                          => 'boolean',
            'liquidos_diarios'              => 'integer|nullable',
            'liquido_consumo'               => 'integer|nullable',
            'suplemento'                    => 'boolean',

            'circunferencia_cintura_tipo'   => 'integer|nullable', 
            'marcapasso'                    => 'boolean',
            'edema'                         => 'boolean',
            'cacifo'                        => 'boolean',
            'lado_dominante'                => 'integer|nullable',
            //Avalição força palmar
            'fp_mao_direita1'               => 'numeric|nullable',
            'fp_mao_direita2'               => 'numeric|nullable',
            'fp_mao_direita3'               => 'numeric|nullable',
            'fp_mao_esquerda1'              => 'numeric|nullable',
            'fp_mao_esquerda2'              => 'numeric|nullable',
            'fp_mao_esquerda3'              => 'numeric|nullable',
            //Exame física
            'c_consumo_musculo_temporal'    => 'boolean',
            'c_consumo_bola_gordurosa'      => 'boolean',
            'c_arco_zigomatico_aparente'    => 'boolean',
            'c_depressao_masseter'          => 'boolean',
            't_clavicula_aparente'          => 'boolean',
            't_esterno_aparente'            => 'boolean',
            't_ombros_quadrados'            => 'boolean',
            'p_proeminência_supra_infra'    => 'boolean',
            'o_esclerotica'                 => 'boolean',
            'o_mucosa_hipocoradas'          => 'boolean',
            'o_orbitas_profundas'           => 'boolean',
            'cf_coloracao_mucosa'           => 'integer|nullable',
            'ms_edema'                      => 'boolean',
            'mi_edema'                      => 'boolean',
            'mi_joelho_quadrado'            => 'boolean',
            'pele_manchas'                  => 'boolean',
            'pele_ressecamento'             => 'boolean',
            'pele_lesoes'                   => 'boolean',
            'pele_turgor'                   => 'boolean',
            'pele_prurido'                  => 'boolean',
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);


        //Atualiza
        //Remove os campos que não devem ser atualizados por aqui
        $dados = $request->except(['dados.paciente_id', 'dados.usuario', 'dados.id', 'dados.usuario_id', 'dados.aprovado'])['dados'];
        
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
