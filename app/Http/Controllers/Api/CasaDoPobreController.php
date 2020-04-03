<?php

namespace App\Http\Controllers\Api;

use App\models\Contato;
use App\Models\Evento;
use App\Models\Foto;
use App\Models\QuemSomos;
use App\Models\Usuario;

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
        $eventos = Evento::with('autor')->get();
        return response()->json(['eventos' => $eventos], 200);
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
