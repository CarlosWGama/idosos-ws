<?php

namespace App\Http\Controllers;

use App\Models\QuemSomos;
use Illuminate\Http\Request;

class HistoricoController extends Controller {

     /** Abre de Historico  */
     public function index() {
        $this->dados['historico'] = QuemSomos::first();
        $this->dados['tinymce'] = true;
        return view('historico.edicao', $this->dados);
    }
    
    /** Tenta editar um conteúdo e salvar no banco
     * @param $id id do contéudo
     */
    public function editar(Request $request) {
        $request->validate(['descricao'  => 'required']);
        QuemSomos::first()->update($request->except(['_token']));

        return redirect()->route('casa.historico')->with(['sucesso' => 'Contato atualizado com sucesso']);
    }
}
