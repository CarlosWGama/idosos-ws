<?php

namespace App\Http\Controllers\Api;

use App\Models\NutEvolucao;
use Illuminate\Http\Request;
use App\Models\NutProntuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;

class ProntuarioNutricaoController extends ApiController {


    protected $areaID = 2;

    // ========================== FICHA ================================// 
    /** Retorna o ultimo prontuário aprovado */
    public function buscarFicha(int $pacienteID) {
        $prontuario = NutProntuario::where('paciente_id', $pacienteID)->orderBy('id', 'desc')->first();
        if (!$prontuario) $prontuario = new \stdClass();
        return response()->json(['prontuario' => $prontuario], 200);
    }

    /** Salvar o prontuário/ficha de um paciente */
    public function salvarFicha(Request $request) {
        $usuarioID = $this->getUsuarioID($request);

        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();
        //Verifica se é para criar ou atualizar
        $prontuario = NutProntuario::where('paciente_id', $request->dados['paciente_id'])->first();
        if ($prontuario == null) $prontuario = new NutProntuario();
        
        //Avalia se é o Dono do Prontuário ou um Professor/Moderador
        if (!in_array($usuario->nivel_acesso, [1, 2]) && $usuario->profissao_id = $this->areaID)
            return response()->json(['Apenas um professor/moderador de nutrição pode editar esse prontuário'], 403);
        
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
        $dados = $request->except(['dados.saude_gastrointestinal', 'dados.membro_amputado', 'dados.id'])['dados'];

        $dados['data'] = date('Y-m-d', strtotime($dados['data']));

        $prontuario->fill($dados);
        $prontuario->save();

        //Saude Gastroinstestinal
        $prontuario->saudeGastrointestinal()->sync($request->dados['saude_gastrointestinal']); 
        //Membro amputado
        $prontuario->membroAmputado()->sync($request->dados['membro_amputado']);

        $prontuario->save();
        return response()->json($prontuario, 200);
    }

    // =========================== EVOLUÇÕES =============================== //
    /** Busca as evoluções de nutrição */
    public function buscarEvolucoes(Request $request, int $pacienteID, int $inicio = 0, int $limite = 10) {
        $evolucoes = NutEvolucao::where('paciente_id', $pacienteID)->offset($inicio)->limit($limite)->orderBy('id', 'desc')->get();
        return response()->json(['evolucoes' => $evolucoes], 200);
    }
    
    /** Cadastra uma nova evolução */
    public function cadastrarEvolucao(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        if ($usuario->profissao_id != $this->areaID)
            return response()->json(['Apenas profissionais de nutrição podem criar esse tipo de evolução'], 403);

        $validation = Validator::make($request->dados, [
            'paciente_id'    => 'required|integer',
            'usuario_id'     => 'required|integer',
            'data'           => 'required',
            'descricao'      => 'required'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->dados;
        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        $dados['aprovado'] = ($usuario->nivel_acesso == 1); //É professor
        
        $evolucao = NutEvolucao::create($dados);
        return response()->json($evolucao, 200);
    }

    /** Atualiza uma Evolução */
    public function atualizarEvolucao(Request $request, int $evolucaoID) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        $evolucao = NutEvolucao::findOrFail($evolucaoID);

        //Não é da area
        if ($usuario->profissao_id != $this->areaID)
            return response()->json(['Apenas profissionais de nutrição podem criar esse tipo de evolução'], 403);
            
        //Caso seja aluno, só pode alterar sua própria evolução
        if ($usuario->nivel_acesso == 3 && $evolucao->usuario_id != $usuario->id)
            return response()->json(['Você só pode editar suas próprias evoluções'], 403);
            
        //Evoluções aprovadas apenas podem ser alteradas por profesosres
        if ($evolucao->aprovado && $usuario->nivel_acesso != 1)
            return response()->json(['Evoluções aprovadas, apenas podem ser alteradas por professores'], 403);
          
        //Validação
        $validation = Validator::make($request->dados, [
            'data'           => 'required',
            'descricao'      => 'required'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Atualiza
        $dados = $request->only(['dados.data', 'dados.descricao'])['dados'];
        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        
        $evolucao->fill($dados);
        $evolucao->save();

        return response()->json($evolucao, 200);
    }
    
    /** Aprova um prontuário */
    public function aprovarEvolucao(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID, [1])) 
            return response()->json('Só professor da área pode aprovar prontuário', 403);
    
        $evolucao = NutEvolucao::where('id', $id)->firstOrFail();
        // if ($prontuario->usuario->professor_id != $usuarioID)
        //     return response()->json('Apenas o professor do aluno pode aprovar seu prontuário', 403);
        
        $evolucao->aprovado = true;
        $evolucao->save();

        return response()->json('Atualizado com sucesso', 200);
    }


}
