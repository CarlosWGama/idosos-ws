<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\EduFisEvolucao;
use App\Models\EduFisProntuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;

class ProntuarioEducacaoFisicaController extends ApiController {
    
    protected $areaID = 5;

    // ========================== FICHA ================================// 
    /** Retorna o ultimo prontuário aprovado */
    public function buscarFicha(int $pacienteID) {
        $prontuario = EduFisProntuario::where('paciente_id', $pacienteID)->orderBy('id', 'desc')->first();
        if (!$prontuario) $prontuario = new EduFisProntuario;
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
            return response()->json(['Apenas um professor/moderador de nutrição pode editar esse prontuário'], 403);
        
        $validation = Validator::make($request->dados, [
            'paciente_id'                       => 'required',
            'data'                              => 'required',
            
            //Ficha principal
            'gricemia_capilar'                  => 'numeric|nullable',
            'pressao_arterial'                  => 'numeric|nullable',
            'frequencia_cardiaca'               => 'numeric|nullable',
            'saturacao'                         => 'numeric|nullable',
            'temperatura'                       => 'numeric|nullable',
            'pas_tornozelo_direito'             => 'numeric|nullable',
            'pas_tornozelo_esquerdo'            => 'numeric|nullable',
            'pas_braquial_direito'              => 'numeric|nullable',
            'pas_braquial_esquerdo'             => 'numeric|nullable',
            'indice_tornozelo_braquial_direito' => 'numeric|nullable',
            'indice_tornozelo_braquial_esquerdo'=> 'numeric|nullable',
            
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

            //Força e Pressão Manual
            'pressoa_manual1'                   => 'numeric|nullable',
            'pressoa_manual2'                   => 'numeric|nullable',
            'pressoa_manual3'                   => 'numeric|nullable'
        
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->except(['dados.id'])['dados'];

        $dados['data'] = date('Y-m-d', strtotime($dados['data']));

        $prontuario->fill($dados);
        $prontuario->save();

        $prontuario->save();
        return response()->json($prontuario, 200);
    }

    // =========================== EVOLUÇÕES =============================== //
    /** Busca as evoluções de nutrição */
    public function buscarEvolucoes(Request $request, int $pacienteID, int $inicio = 0, int $limite = 10) {
        $evolucoes = EduFisEvolucao::where('paciente_id', $pacienteID)->offset($inicio)->limit($limite)->orderBy('id', 'desc')->get();
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

        //Cadastra
        $dados = $request->dados;
        $dados['usuario_id'] = $usuarioID;
        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
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
            return response()->json(['Apenas profissionais de nutrição podem criar esse tipo de evolução'], 403);
            
        //Caso seja aluno, só pode alterar sua própria evolução
        if ($usuario->nivel_acesso == 3 && $evolucao->usuario_id != $usuario->id)
            return response()->json(['Você só pode editar suas próprias evoluções'], 403);
            
        //Evoluções aprovadas apenas podem ser alteradas por profesosres
        if ($evolucao->aprovado && $usuario->nivel_acesso != 1)
            return response()->json(['Evoluções aprovadas, apenas podem ser alteradas por professores'], 403);
          
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
}
