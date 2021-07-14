<?php

namespace App\Http\Controllers\Api;

use App\Models\EnfermagemProntuario;
use App\Http\Controllers\Controller;
use App\Models\EnfermagemConsultaClinica;
use App\Models\EnfermagemEvolucao;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProntuarioEnfermagemController extends ApiController
{
    protected $areaID = 6;

    // ========================== FICHA ================================// 
    /** Retorna o ultimo prontuário aprovado */
    public function buscarFicha(int $pacienteID) {
        $prontuario = EnfermagemProntuario::where('paciente_id', $pacienteID)->orderBy('id', 'desc')->first();
        if (!$prontuario) $prontuario = new \stdClass();
        return response()->json(['prontuario' => $prontuario], 200);
    }

    /** Salvar o prontuário/ficha de um paciente */
    public function salvarFicha(Request $request) {
        $usuarioID = $this->getUsuarioID($request);

        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();
        //Verifica se é para criar ou atualizar
        $prontuario = EnfermagemProntuario::where('paciente_id', $request->dados['paciente_id'])->first();
        if ($prontuario == null) $prontuario = new EnfermagemProntuario();
        
        //Avalia se é o Dono do Prontuário ou um Professor/Moderador
        if (!in_array($usuario->nivel_acesso, [1, 2]) && $usuario->profissao_id = $this->areaID)
            return response()->json(['Apenas um professor/moderador de enfermagem pode editar esse prontuário'], 403);
        
        $validation = Validator::make($request->dados, [
            'paciente_id'           => 'required',
            'data'                  => 'required',
            'estatura'              => 'integer|nullable',
            'perimetro_braquial'    => 'integer|nullable',
            'osteoporose'           => 'boolean|nullable',
            'demencia'              => 'boolean|nullable',
            
            //Avaliação Multidimensional (alterações)
            'nutricao'              => 'boolean|nullable',
            'visao'                 => 'boolean|nullable',
            'audicao'               => 'boolean|nullable',
            'incontinencia'         => 'boolean|nullable',
            'depressao'             => 'boolean|nullable',
            'cognicao'              => 'boolean|nullable',
            'mmss'                  => 'boolean|nullable',
            'mmii'                  => 'boolean|nullable',
            'queda'                 => 'boolean|nullable'
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->except(['dados.id'])['dados'];

        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        if (!empty($dados['depressao_data'])) $dados['depressao_data'] = date('Y-m-d', strtotime($dados['depressao_data']));
        if (!empty($dados['mmss_data'])) $dados['mmss_data'] = date('Y-m-d', strtotime($dados['mmss_data']));
        if (!empty($dados['mmii_data'])) $dados['mmii_data'] = date('Y-m-d', strtotime($dados['mmii_data']));
        if (!empty($dados['queda_data'])) $dados['queda_data'] = date('Y-m-d', strtotime($dados['queda_data']));

        $prontuario->fill($dados);
        $prontuario->save();

        return response()->json($prontuario, 200);
    }

    // =========================== EVOLUÇÕES =============================== //
    /** Busca as evoluções de educação física */
    public function buscarEvolucoes(Request $request, int $pacienteID, int $inicio = 0, int $limite = 10) {
        $evolucoes = EnfermagemEvolucao::where('paciente_id', $pacienteID)->offset($inicio)->limit($limite)->orderBy('id', 'desc')->get();
        return response()->json(['evolucoes' => $evolucoes], 200);
    }
    
    /** Cadastra uma nova evolução */
    public function cadastrarEvolucao(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        if ($usuario->profissao_id != $this->areaID)
            return response()->json(['Apenas profissionais de enfermagem podem criar esse tipo de evolução'], 403);

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
        $dados['aprovado'] = ($usuario->nivel_acesso == 1); //É professor
        
        $evolucao = EnfermagemEvolucao::create($dados);
        return response()->json($evolucao, 200);
    }

    /** Atualiza uma Evolução */
    public function atualizarEvolucao(Request $request, int $evolucaoID) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        $evolucao = EnfermagemEvolucao::findOrFail($evolucaoID);

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
    
        $evolucao = EnfermagemEvolucao::where('id', $id)->firstOrFail();
        
        $evolucao->aprovado = true;
        $evolucao->save();

        return response()->json('Atualizado com sucesso', 200);
    }

    // =========================== CONSULTA CLINICA =============================== //
    /** Busca os consultas clinicas */
    public function buscarConsultasClinicas(Request $request, int $pacienteID, int $inicio = 0, int $limite = 10) {
        $consultas = EnfermagemConsultaClinica::where('paciente_id', $pacienteID)->offset($inicio)->limit($limite)->orderBy('id', 'desc')->get();
        return response()->json(['consultas' => $consultas], 200);
    }
    
    /** Cadastra um consulta clinica */
    public function cadastrarConsultaClinica(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        if ($usuario->profissao_id != $this->areaID)
            return response()->json(['Apenas profissionais de enfermagem podem criar esse tipo de consulta clinica'], 403);

        $validation = Validator::make($request->dados, [
            'paciente_id'    => 'required|integer',
            'data'           => 'required',

            //Consulta
            'peso'                          => 'numeric|nullable',
            'imc'                           => 'numeric|nullable',
            'alteracao_pes'                 => 'boolean|nullable',
            'alteracao_fisico'              => 'boolean|nullable',
            'fragilidade'                   => 'boolean|nullable',
            'orientacao_nutricional'        => 'boolean|nullable',
            'orientacao_atividade_fisica'   => 'boolean|nullable',
        
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->dados;
        $dados['usuario_id'] = $usuarioID;
        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        if (!empty($dados['peso'])) $dados['peso'] = number_format($dados['peso'], 3, '.', '');
        if (!empty($dados['imc'])) $dados['imc'] = number_format($dados['imc'], 2, '.', '');
        $dados['aprovado'] = ($usuario->nivel_acesso == 1); //É professor
        
        $consulta = EnfermagemConsultaClinica::create($dados);
        return response()->json($consulta, 200);
    }

    /** Atualiza um Teste de Consulta Clinica */
    public function atualizarConsultaClinica(Request $request, int $consultaID) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        $consulta = EnfermagemConsultaClinica::findOrFail($consultaID);

        //Não é da area
        if ($usuario->profissao_id != $this->areaID)
            return response()->json(['Apenas profissionais de educação física podem criar esse tipo de consulta'], 403);
            
        //Caso seja aluno, só pode alterar sua própria evolução
        if ($usuario->nivel_acesso == 3 && $consulta->usuario_id != $usuario->id)
            return response()->json(['Você só pode editar seus próprios consultas clinicas'], 403);
            
        //Evoluções aprovadas apenas podem ser alteradas por profesosres
        if ($consulta->aprovado && $usuario->nivel_acesso != 1)
            return response()->json(['Teste de ConsultaClinica aprovados, apenas podem ser alteradas por professores'], 403);
          
        //Validação
        $validation = Validator::make($request->dados, [
            'data'                              => 'required',
            //Consulta
            'peso'                          => 'numeric|nullable',
            'imc'                           => 'numeric|nullable',
            'alteracao_pes'                 => 'boolean|nullable',
            'alteracao_fisico'              => 'boolean|nullable',
            'fragilidade'                   => 'boolean|nullable',
            'orientacao_nutricional'        => 'boolean|nullable',
            'orientacao_atividade_fisica'   => 'boolean|nullable',
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Atualiza
        $dados = $request->except(['dados.id', 'dados.usuario_id'])['dados'];
        $dados['data'] = date('Y-m-d', strtotime($dados['data']));
        if (!empty($dados['peso'])) $dados['peso'] = number_format($dados['peso'], 3, '.', '');
        if (!empty($dados['imc'])) $dados['imc'] = number_format($dados['imc'], 2, '.', '');
        $consulta->fill($dados);
        $consulta->save();

        return response()->json($consulta, 200);
    }
    
    /** Aprova um consulta clinica */
    public function aprovarConsultaClinica(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        //Acesso negado para aluno
        if (!$this->validaAcesso($usuarioID, [1])) 
            return response()->json('Só professor da área pode aprovar consulta', 403);
    
        $consulta = EnfermagemConsultaClinica::where('id', $id)->firstOrFail();
        
        $consulta->aprovado = true;
        $consulta->save();

        return response()->json('Atualizado com sucesso', 200);
    }
}
