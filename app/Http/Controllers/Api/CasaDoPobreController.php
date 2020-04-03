<?php

namespace App\Http\Controllers\Api;

use App\models\Contato;
use App\Models\Evento;
use App\Models\Foto;
use App\Models\QuemSomos;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CasaDoPobreController extends ApiController {

    /** Retorna o histórico da Casa do Pobre */
    public function historico() {
        $historico = QuemSomos::first();
        return response()->json($historico->descricao, 200);
    }

    /** Retorna as fotos */
    public function fotos() {
        $fotos = Foto::all();
        return response()->json(['fotos' => $fotos], 200);
    }

    /** Retorna os eventos da agenda */
    public function agenda() {
        $eventos = Evento::with('autor')->orderBy('data')->orderBy('id')->get();
        return response()->json(['eventos' => $eventos], 200);
    }

    /** Cadastra um novo evento */
    public function cadastrarEvento(Request $request) {
        $usuarioID = $this->getUsuarioID($request);
        $professor = Usuario::findOrFail($usuarioID);

        $validation = Validator::make($request->evento, [
            'descricao'          => 'required',
            'recorrente'         => 'required',
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);
        
        //Inicio cadastro do aluno
        $evento = $request->evento;
        $evento['autor_id'] = $professor->id;
        if (!empty($evento['data'])) $evento['data'] = substr($evento['data'], 0, 10);
        
        //Salva o aluno
        $evento = Evento::create($evento);
        
        return response()->json($evento, 201);
    }

    /**
     * Remove um evento
     * @param $id ID do evento
     */
    public function excluirEvento(Request $request, int $id) {
        $usuarioID = $this->getUsuarioID($request);
        $evento = Evento::where('autor_id', $usuarioID)->where('id', $id)->firstOrFail();
        $evento->delete();
        return response()->json('Evento excluido com sucesso', 200);
    }

    /** Contatos */
    public function contatos() {
        $contatos = Contato::all();
        return response()->json(['contatos' => $contatos], 200);
    }

    /** Equipe Profissional */
    public function equipe() {
        $equipe = Usuario::with('profissao')->where('exibir', true)->get();
        return response()->json(['equipe' => $equipe], 200);
    }


}
