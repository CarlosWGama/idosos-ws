<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FisioEvolucao;
use App\Models\FisioProntuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;

class ProntuarioFisioterapiaController extends ApiController {
    
    protected $areaID = 4;

    // ========================== FICHA ================================// 
    /** Retorna o ultimo prontuário aprovado */
    public function buscarFicha(int $pacienteID) {
        $prontuario = FisioProntuario::where('paciente_id', $pacienteID)->orderBy('id', 'desc')->first();
        if (!$prontuario) $prontuario = new \stdClass();
        return response()->json(['prontuario' => $prontuario], 200);
    }

    /** Salvar o prontuário/ficha de um paciente */
    public function salvarFicha(Request $request) {
        $usuarioID = $this->getUsuarioID($request);

        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();
        //Verifica se é para criar ou atualizar
        $prontuario = FisioProntuario::where('paciente_id', $request->dados['paciente_id'])->first();
        if ($prontuario == null) $prontuario = new FisioProntuario();
        
        //Avalia se é o Dono do Prontuário ou um Professor/Moderador
        if (!in_array($usuario->nivel_acesso, [1, 2]) && $usuario->profissao_id = $this->areaID)
            return response()->json(['Apenas um professor/moderador de fisioterapia pode editar esse prontuário'], 403);
        
        $validation = Validator::make($request->dados, [
            'paciente_id'                   => 'required',
            'data'                          => 'required',
         
            //Mini Mental Teste
            'clock_task'                    => 'integer|nullable', 
            'barthel'                       => 'integer|nullable', 
            'ppt'                           => 'integer|nullable', 
            
            //Sinais Vitais
            'fc'                            => 'integer|nullable', 
            'fr'                            => 'integer|nullable', 
            't'                             => 'integer|nullable', 
            
            //Outros
            'nivel_consciencia'             => 'integer|nullable', 
            'estado_mental'                 => 'integer|nullable', 
            
            //Sistema respiratório
            'sistema_respiratorio'          => 'integer|nullable', 
            'ritmo'                         => 'integer|nullable', 
            'padrao_muscular_ventilatório'  => 'integer|nullable', 
            'expansibilidade_toracica'      => 'integer|nullable', 
            'ausculta'                      => 'integer|nullable', 
            'ruidos_adventicios'            => 'integer|nullable', 
            'tosse'                         => 'integer|nullable', 
            
            //SIstema Osteomioarticular
            'sistema_osteomioarticular'     => 'integer|nullable', 
            'forca_muscular'                => 'integer|nullable', 
            'tonus'                         => 'integer|nullable', 
            'amplitude_articular_normal'    => 'boolean|nullable', 
            'amplitude_articular_diminuida' => 'boolean|nullable', 
            'amplitude_articular_luxacao'   => 'boolean|nullable', 
            'amplitude_articular_rigidez'   => 'boolean|nullable', 
            'amplitude_articular_fratura'   => 'boolean|nullable', 
            'amplitude_articular_desvio'    => 'boolean|nullable', 
            
            //Deambulação
            'deambulacao'                   => 'integer|nullable', 
            'equilibrio'                    => 'integer|nullable', 
            'edema_grau'                    => 'integer|nullable', 
            'aparelho_genitourinario'       => 'integer|nullable'
            
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->except(['dados.saude_gastrointestinal', 'dados.membro_amputado', 'dados.id'])['dados'];

        $dados['data'] = date('Y-m-d', strtotime($dados['data']));

        $prontuario->fill($dados);
        $prontuario->save();

        $prontuario->save();
        return response()->json($prontuario, 200);
    }

    // =========================== EVOLUÇÕES =============================== //
    /** Busca as evoluções de fisioterapia */
    public function buscarEvolucoes(Request $request, int $pacienteID, int $inicio = 0, int $limite = 10) {
        $evolucoes = FisioEvolucao::where('paciente_id', $pacienteID)->offset($inicio)->limit($limite)->orderBy('id', 'desc')->get();
        return response()->json(['evolucoes' => $evolucoes], 200);
    }
    
    /** Cadastra uma nova evolução */
    public function cadastrarEvolucao(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        if ($usuario->profissao_id != $this->areaID)
            return response()->json(['Apenas profissionais de fisioterapia podem criar esse tipo de evolução'], 403);

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
        
        $evolucao = FisioEvolucao::create($dados);
        return response()->json($evolucao, 200);
    }

    /** Atualiza uma Evolução */
    public function atualizarEvolucao(Request $request, int $evolucaoID) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        $evolucao = FisioEvolucao::findOrFail($evolucaoID);

        //Não é da area
        if ($usuario->profissao_id != $this->areaID)
            return response()->json(['Apenas profissionais de fisioterapia podem criar esse tipo de evolução'], 403);
            
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
    
        $evolucao = FisioEvolucao::where('id', $id)->firstOrFail();
        // if ($prontuario->usuario->professor_id != $usuarioID)
        //     return response()->json('Apenas o professor do aluno pode aprovar seu prontuário', 403);
        
        $evolucao->aprovado = true;
        $evolucao->save();

        return response()->json('Atualizado com sucesso', 200);
    }

}
