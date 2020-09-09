<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\EduFisEvolucao;
use App\Models\EduFisAcompanhamento;
use App\Models\EduFisProntuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;

class ProntuarioEducacaoFisicaController extends ApiController {
    
    protected $areaID = 5;

    // ========================== FICHA ================================// 
    /** Retorna o ultimo prontuário aprovado */
    public function buscarFicha(int $pacienteID) {
        $prontuario = EduFisProntuario::where('paciente_id', $pacienteID)->orderBy('id', 'desc')->first();
        if (!$prontuario) $prontuario = new \stdClass();
        return response()->json(['prontuario' => $prontuario], 200);
    }

    /** Salvar o prontuário/ficha de um paciente */
    public function salvarFicha(Request $request) {
        $usuarioID = $this->getUsuarioID($request);

        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();
        //Verifica se é para criar ou atualizar
        $prontuario = EduFisProntuario::where('paciente_id', $request->dados['paciente_id'])->first();
        if ($prontuario == null) $prontuario = new EduFisProntuario();
        
        //Avalia se é o Dono do Prontuário ou um Professor/Moderador
        if (!in_array($usuario->nivel_acesso, [1, 2]) && $usuario->profissao_id = $this->areaID)
            return response()->json(['Apenas um professor/moderador de educação física pode editar esse prontuário'], 403);
        
        $validation = Validator::make($request->dados, [
            'paciente_id'                       => 'required',
            'data'                              => 'required',
            
            //Ficha principal
            'glicemia_capilar'                  => 'nullable|numeric',
            'frequencia_cardiaca'               => 'integer|nullable',
            'saturacao'                         => 'integer|nullable',
            'temperatura'                       => 'numeric|nullable',
            
            //Desempenho Funcional
            'sentar_cadeira'                    => 'integer|nullable',
            'flexao_cotovelo'                   => 'integer|nullable',
            'sentar_pes'                        => 'integer|nullable',
            'time_up_go'                        => 'integer|nullable',
            'costas_maos'                       => 'integer|nullable',
            'caminhada'                         => 'integer|nullable',
            
            //Antropometria
            'massa_corporal'                    => 'numeric|nullable',
            'imc'                               => 'numeric|nullable',
            'estatura'                          => 'integer|nullable',
            'perimetro_quadril'                 => 'integer|nullable',
            'circuferencia_antebraco'           => 'integer|nullable',
            'circuferencia_panturrilha'         => 'integer|nullable',
            'altura_joelho'                     => 'integer|nullable',
            'dobra_coxa'                        => 'integer|nullable',
            'mma'                               => 'numeric|nullable',
            'imma'                              => 'numeric|nullable',

            //Força e Pressão Manual
            'preensao_manual1'                   => 'numeric|nullable',
            'preensao_manual2'                   => 'numeric|nullable',
            'preensao_manual3'                   => 'numeric|nullable'
        
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->except(['dados.id'])['dados'];

        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        if (!empty($dados['glicemia_capilar'])) $dados['glicemia_capilar'] = number_format($dados['glicemia_capilar'], 2, '.', '');
        if (!empty($dados['temperatura'])) $dados['temperatura'] = number_format($dados['temperatura'], 2, '.', '');
        if (!empty($dados['massa_corporal'])) $dados['massa_corporal'] = number_format($dados['massa_corporal'], 3, '.', '');
        if (!empty($dados['imc'])) $dados['imc'] = number_format($dados['imc'], 2, '.', '');
        if (!empty($dados['preensao_manual1'])) $dados['preensao_manual1'] = number_format($dados['preensao_manual1'], 3, '.', '');
        if (!empty($dados['preensao_manual2'])) $dados['preensao_manual2'] = number_format($dados['preensao_manual2'], 3, '.', '');
        if (!empty($dados['preensao_manual3'])) $dados['preensao_manual3'] = number_format($dados['preensao_manual3'], 3, '.', '');
        $prontuario->fill($dados);
        $prontuario->save();

        $prontuario->save();
        return response()->json($prontuario, 200);
    }

    // =========================== EVOLUÇÕES =============================== //
    /** Busca as evoluções de educação física */
    public function buscarEvolucoes(Request $request, int $pacienteID, int $inicio = 0, int $limite = 10) {
        $evolucoes = EduFisEvolucao::where('paciente_id', $pacienteID)->offset($inicio)->limit($limite)->orderBy('id', 'desc')->get();
        return response()->json(['evolucoes' => $evolucoes], 200);
    }
    
    /** Cadastra uma nova evolução */
    public function cadastrarEvolucao(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        if ($usuario->profissao_id != $this->areaID)
            return response()->json(['Apenas profissionais de educação física podem criar esse tipo de evolução'], 403);

        $validation = Validator::make($request->dados, [
            'paciente_id'    => 'required|integer',
            'data'           => 'required',
            'descricao'      => 'required'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->dados;
        $dados['usuario_id'] = $usuarioID;
        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        if (!empty($dados['massa_corporal'])) $dados['massa_corporal'] = number_format($dados, 3, '.', '');
        if (!empty($dados['imc'])) $dados['imc'] = number_format($dados, 2, '.', '');
        if (!empty($dados['preensao_manual1'])) $dados['preensao_manual1'] = number_format($dados, 3, '.', '');
        if (!empty($dados['preensao_manual2'])) $dados['preensao_manual2'] = number_format($dados, 3, '.', '');
        if (!empty($dados['preensao_manual3'])) $dados['preensao_manual3'] = number_format($dados, 3, '.', '');
        $dados['aprovado'] = ($usuario->nivel_acesso == 1); //É professor
        
        $evolucao = EduFisEvolucao::create($dados);
        return response()->json($evolucao, 200);
    }

    /** Atualiza uma Evolução */
    public function atualizarEvolucao(Request $request, int $evolucaoID) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        $evolucao = EduFisEvolucao::findOrFail($evolucaoID);

        //Não é da area
        if ($usuario->profissao_id != $this->areaID)
            return response()->json(['Apenas profissionais de educação física podem criar esse tipo de evolução'], 403);
            
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
        $dados = $request->except(['dados.id', 'dados.usuario_id'])['dados'];
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
    
        $evolucao = EduFisEvolucao::where('id', $id)->firstOrFail();
        
        $evolucao->aprovado = true;
        $evolucao->save();

        return response()->json('Atualizado com sucesso', 200);
    }

    // =========================== TESTE DE ACOMPANHAMENTO =============================== //
    /** Busca os testes de acompanhamento */
    public function buscarAcompanhamentos(Request $request, int $pacienteID, int $inicio = 0, int $limite = 10) {
        $evolucoes = EduFisAcompanhamento::where('paciente_id', $pacienteID)->offset($inicio)->limit($limite)->orderBy('id', 'desc')->get();
        return response()->json(['acompanhamentos' => $evolucoes], 200);
    }
    
    /** Cadastra um teste de acompanhamento */
    public function cadastrarAcompanhamento(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        if ($usuario->profissao_id != $this->areaID)
            return response()->json(['Apenas profissionais de educação física podem criar esse tipo de teste de acompanhamento'], 403);

        $validation = Validator::make($request->dados, [
            'paciente_id'    => 'required|integer',
            'data'           => 'required',

            //Desempenho Funcional
            'sentar_cadeira'                    => 'integer|nullable',
            'flexao_cotovelo'                   => 'integer|nullable',
            'sentar_pes'                        => 'integer|nullable',
            'time_up_go'                        => 'integer|nullable',
            'costas_maos'                       => 'integer|nullable',
            'caminhada'                         => 'integer|nullable',
            
            //Antropometria
            'massa_corporal'                    => 'numeric|nullable',
            'imc'                               => 'numeric|nullable',
            'estatura'                          => 'integer|nullable',
            'perimetro_quadril'                 => 'integer|nullable',
            'circuferencia_antebraco'           => 'integer|nullable',
            'circuferencia_panturrilha'         => 'integer|nullable',
            'altura_joelho'                     => 'integer|nullable',
            'dobra_coxa'                        => 'integer|nullable',
            'mma'                               => 'numeric|nullable',
            'imma'                              => 'numeric|nullable',

            //Força e Pressão Manual
            'preensao_manual1'                   => 'numeric|nullable',
            'preensao_manual2'                   => 'numeric|nullable',
            'preensao_manual3'                   => 'numeric|nullable',

            //Hemodinâmica
            'pas'                               => 'integer|nullable',
            'pad'                               => 'integer|nullable',
            'fc'                                => 'integer|nullable'


        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->dados;
        $dados['usuario_id'] = $usuarioID;
        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        if (!empty($dados['massa_corporal'])) $dados['massa_corporal'] = number_format($dados['massa_corporal'], 3, '.', '');
        if (!empty($dados['imc'])) $dados['imc'] = number_format($dados['imc'], 2, '.', '');
        if (!empty($dados['preensao_manual1'])) $dados['preensao_manual1'] = number_format($dados['preensao_manual1'], 3, '.', '');
        if (!empty($dados['preensao_manual2'])) $dados['preensao_manual2'] = number_format($dados['preensao_manual2'], 3, '.', '');
        if (!empty($dados['preensao_manual3'])) $dados['preensao_manual3'] = number_format($dados['preensao_manual3'], 3, '.', '');
        $dados['aprovado'] = ($usuario->nivel_acesso == 1); //É professor
        
        $acompanhamento = EduFisAcompanhamento::create($dados);
        return response()->json($acompanhamento, 200);
    }

    /** Atualiza um Teste de Acompanhamento */
    public function atualizarAcompanhamento(Request $request, int $acompanhamentoID) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        $acompanhamento = EduFisAcompanhamento::findOrFail($acompanhamentoID);

        //Não é da area
        if ($usuario->profissao_id != $this->areaID)
            return response()->json(['Apenas profissionais de educação física podem criar esse tipo de acompanhamento'], 403);
            
        //Caso seja aluno, só pode alterar sua própria evolução
        if ($usuario->nivel_acesso == 3 && $acompanhamento->usuario_id != $usuario->id)
            return response()->json(['Você só pode editar seus próprios testes de acompanhamento'], 403);
            
        //Evoluções aprovadas apenas podem ser alteradas por profesosres
        if ($acompanhamento->aprovado && $usuario->nivel_acesso != 1)
            return response()->json(['Teste de Acompanhamento aprovados, apenas podem ser alteradas por professores'], 403);
          
        //Validação
        $validation = Validator::make($request->dados, [
            'data'                              => 'required',
            //Desempenho Funcional
            'sentar_cadeira'                    => 'integer|nullable',
            'flexao_cotovelo'                   => 'integer|nullable',
            'sentar_pes'                        => 'integer|nullable',
            'time_up_go'                        => 'integer|nullable',
            'costas_maos'                       => 'integer|nullable',
            'caminhada'                         => 'integer|nullable',
            
            //Antropometria
            'massa_corporal'                    => 'numeric|nullable',
            'imc'                               => 'numeric|nullable',
            'estatura'                          => 'integer|nullable',
            'perimetro_quadril'                 => 'integer|nullable',
            'circuferencia_antebraco'           => 'integer|nullable',
            'circuferencia_panturrilha'         => 'integer|nullable',
            'altura_joelho'                     => 'integer|nullable',
            'dobra_coxa'                        => 'integer|nullable',
            'mma'                               => 'numeric|nullable',
            'imma'                              => 'numeric|nullable',

            //Força e Pressão Manual
            'pressoa_manual1'                   => 'numeric|nullable',
            'pressoa_manual2'                   => 'numeric|nullable',
            'pressoa_manual3'                   => 'numeric|nullable',

            //Hemodinâmica
            'pas'                               => 'integer|nullable',
            'pad'                               => 'integer|nullable',
            'fc'                                => 'integer|nullable'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Atualiza
        $dados = $request->except(['dados.id', 'dados.usuario_id'])['dados'];
        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        $acompanhamento->fill($dados);
        $acompanhamento->save();

        return response()->json($acompanhamento, 200);
    }
    
    /** Aprova um teste de acompanhamento */
    public function aprovarAcompanhamento(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID, [1])) 
            return response()->json('Só professor da área pode aprovar prontuário', 403);
    
        $acompanhamento = EduFisAcompanhamento::where('id', $id)->firstOrFail();
        
        $acompanhamento->aprovado = true;
        $acompanhamento->save();

        return response()->json('Atualizado com sucesso', 200);
    }
}
