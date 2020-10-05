<?php

namespace App\Http\Controllers\Api;

use App\Models\OdontoEvolucao;
use App\Models\OdontoProntuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProntuarioOdontologiaController  extends ApiController {


    protected $areaID = 3;

    // ========================== FICHA ================================//
    /** Retorna o ultimo prontuário aprovado */
    public function buscarFicha(int $pacienteID) {
        $prontuario = OdontoProntuario::where('paciente_id', $pacienteID)->orderBy('id', 'desc')->first();
        if (!$prontuario) $prontuario = new \stdClass();
        return response()->json(['prontuario' => $prontuario], 200);
    }

    /** Salvar o prontuário/ficha de um paciente */
    public function salvarFicha(Request $request) {
        $usuarioID = $this->getUsuarioID($request);

        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();
        //Verifica se é para criar ou atualizar
        $prontuario = OdontoProntuario::where('paciente_id', $request->dados['paciente_id'])->first();
        if ($prontuario == null) $prontuario = new OdontoProntuario();

        //Avalia se é o Dono do Prontuário ou um Professor/Moderador
        if (!in_array($usuario->nivel_acesso, [1, 2]) && $usuario->profissao_id = $this->areaID)
            return response()->json(['Apenas um professor/moderador de nutrição pode editar esse prontuário'], 403);

        $validation = Validator::make($request->dados, [
            'paciente_id'                   => 'required',
            'data'                          => 'required',
            //Odontograma
            'odontograma_18'                => 'integer|nullable',
            'odontograma_17'                => 'integer|nullable',
            'odontograma_16'                => 'integer|nullable',
            'odontograma_15'                => 'integer|nullable',
            'odontograma_14'                => 'integer|nullable',
            'odontograma_13'                => 'integer|nullable',
            'odontograma_12'                => 'integer|nullable',
            'odontograma_11'                => 'integer|nullable',
            'odontograma_21'                => 'integer|nullable',
            'odontograma_22'                => 'integer|nullable',
            'odontograma_23'                => 'integer|nullable',
            'odontograma_24'                => 'integer|nullable',
            'odontograma_25'                => 'integer|nullable',
            'odontograma_26'                => 'integer|nullable',
            'odontograma_27'                => 'integer|nullable',
            'odontograma_28'                => 'integer|nullable',
            'odontograma_38'                => 'integer|nullable',
            'odontograma_37'                => 'integer|nullable',
            'odontograma_36'                => 'integer|nullable',
            'odontograma_35'                => 'integer|nullable',
            'odontograma_34'                => 'integer|nullable',
            'odontograma_33'                => 'integer|nullable',
            'odontograma_32'                => 'integer|nullable',
            'odontograma_31'                => 'integer|nullable',
            'odontograma_41'                => 'integer|nullable',
            'odontograma_42'                => 'integer|nullable',
            'odontograma_43'                => 'integer|nullable',
            'odontograma_44'                => 'integer|nullable',
            'odontograma_45'                => 'integer|nullable',
            'odontograma_46'                => 'integer|nullable',
            'odontograma_47'                => 'integer|nullable',
            'odontograma_48'                => 'integer|nullable',

            'condicoes_dentais_18'                => 'max:255|nullable',
            'condicoes_dentais_17'                => 'max:255|nullable',
            'condicoes_dentais_16'                => 'max:255|nullable',
            'condicoes_dentais_15'                => 'max:255|nullable',
            'condicoes_dentais_14'                => 'max:255|nullable',
            'condicoes_dentais_13'                => 'max:255|nullable',
            'condicoes_dentais_12'                => 'max:255|nullable',
            'condicoes_dentais_11'                => 'max:255|nullable',
            'condicoes_dentais_21'                => 'max:255|nullable',
            'condicoes_dentais_22'                => 'max:255|nullable',
            'condicoes_dentais_23'                => 'max:255|nullable',
            'condicoes_dentais_24'                => 'max:255|nullable',
            'condicoes_dentais_25'                => 'max:255|nullable',
            'condicoes_dentais_26'                => 'max:255|nullable',
            'condicoes_dentais_27'                => 'max:255|nullable',
            'condicoes_dentais_28'                => 'max:255|nullable',
            'condicoes_dentais_38'                => 'max:255|nullable',
            'condicoes_dentais_37'                => 'max:255|nullable',
            'condicoes_dentais_36'                => 'max:255|nullable',
            'condicoes_dentais_35'                => 'max:255|nullable',
            'condicoes_dentais_34'                => 'max:255|nullable',
            'condicoes_dentais_33'                => 'max:255|nullable',
            'condicoes_dentais_32'                => 'max:255|nullable',
            'condicoes_dentais_31'                => 'max:255|nullable',
            'condicoes_dentais_41'                => 'max:255|nullable',
            'condicoes_dentais_42'                => 'max:255|nullable',
            'condicoes_dentais_43'                => 'max:255|nullable',
            'condicoes_dentais_44'                => 'max:255|nullable',
            'condicoes_dentais_45'                => 'max:255|nullable',
            'condicoes_dentais_46'                => 'max:255|nullable',
            'condicoes_dentais_47'                => 'max:255|nullable',
            'condicoes_dentais_48'                => 'max:255|nullable',

            'avaliacao_periodontal_18'            => 'integer|nullable',
            'avaliacao_periodontal_17'            => 'integer|nullable',
            'avaliacao_periodontal_16'            => 'integer|nullable',
            'avaliacao_periodontal_15'            => 'integer|nullable',
            'avaliacao_periodontal_14'            => 'integer|nullable',
            'avaliacao_periodontal_13'            => 'integer|nullable',
            'avaliacao_periodontal_12'            => 'integer|nullable',
            'avaliacao_periodontal_11'            => 'integer|nullable',
            'avaliacao_periodontal_21'            => 'integer|nullable',
            'avaliacao_periodontal_22'            => 'integer|nullable',
            'avaliacao_periodontal_23'            => 'integer|nullable',
            'avaliacao_periodontal_24'            => 'integer|nullable',
            'avaliacao_periodontal_25'            => 'integer|nullable',
            'avaliacao_periodontal_26'            => 'integer|nullable',
            'avaliacao_periodontal_27'            => 'integer|nullable',
            'avaliacao_periodontal_28'            => 'integer|nullable',
            'avaliacao_periodontal_38'            => 'integer|nullable',
            'avaliacao_periodontal_37'            => 'integer|nullable',
            'avaliacao_periodontal_36'            => 'integer|nullable',
            'avaliacao_periodontal_35'            => 'integer|nullable',
            'avaliacao_periodontal_34'            => 'integer|nullable',
            'avaliacao_periodontal_33'            => 'integer|nullable',
            'avaliacao_periodontal_32'            => 'integer|nullable',
            'avaliacao_periodontal_31'            => 'integer|nullable',
            'avaliacao_periodontal_41'            => 'integer|nullable',
            'avaliacao_periodontal_42'            => 'integer|nullable',
            'avaliacao_periodontal_43'            => 'integer|nullable',
            'avaliacao_periodontal_44'            => 'integer|nullable',
            'avaliacao_periodontal_45'            => 'integer|nullable',
            'avaliacao_periodontal_46'            => 'integer|nullable',
            'avaliacao_periodontal_47'            => 'integer|nullable',
            'avaliacao_periodontal_48'            => 'integer|nullable',

            'protese_superior'                   => 'integer|nullable',
            'protese_inferior'                   => 'integer|nullable',
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->except(['dados.id'])['dados'];

        $dados['data'] = date('Y-m-d', strtotime($dados['data']));

        $prontuario->fill($dados);
        $prontuario->save();
        return response()->json($prontuario, 200);
    }

    // =========================== EVOLUÇÕES =============================== //
    /** Busca as evoluções de nutrição */
    public function buscarEvolucoes(Request $request, int $pacienteID, int $inicio = 0, int $limite = 10) {
        $evolucoes = OdontoEvolucao::where('paciente_id', $pacienteID)->offset($inicio)->limit($limite)->orderBy('id', 'desc')->get();
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

        $evolucao = OdontoEvolucao::create($dados);
        return response()->json($evolucao, 200);
    }

    /** Atualiza uma Evolução */
    public function atualizarEvolucao(Request $request, int $evolucaoID) {
        $usuarioID = $this->getUsuarioID($request);
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        $evolucao = OdontoEvolucao::findOrFail($evolucaoID);

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

        $evolucao = OdontoEvolucao::where('id', $id)->firstOrFail();
        // if ($prontuario->usuario->professor_id != $usuarioID)
        //     return response()->json('Apenas o professor do aluno pode aprovar seu prontuário', 403);

        $evolucao->aprovado = true;
        $evolucao->save();

        return response()->json('Atualizado com sucesso', 200);
    }


}
