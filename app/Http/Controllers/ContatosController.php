<?php

namespace App\Http\Controllers;

use App\models\Contato;
use Illuminate\Http\Request;

class ContatosController extends Controller {

    private $dados = ['menu' => 'casa-do-pobre'];

    /** Lista os conteúdos cadastrados */
    public function index() {
        $this->dados['contatos'] = Contato::paginate(10);
        return view('contatos.listar', $this->dados);
    }

    /** 
     * Abre a tela cadastrar novo conteúdo
     */
    public function novo() {
        $this->dados['contato'] = new Contato();
        return view('contatos.novo', $this->dados);
    }

    /** 
     * Tenta salvar um novo conteúdo
     */
    public function cadastrar(Request $request) {
        $request->validate([
            'campo'  => 'required',
            'valor'  => 'required',
        ]);
        Contato::create($request->all());

        return redirect()->route('contatos.listar')->with(['sucesso' => 'Contato cadastrado com sucesso']);
    }

    /** 
     * Abre a tela de editar conteudo
     * @param $id id do conteudo
     */
    public function edicao(int $id) {
        $this->dados['contato'] = Contato::findOrFail($id);
        return view('contatos.edicao', $this->dados);
    }
    
    /** Tenta editar um conteúdo e salvá-lo no banco
     * @param $id id do conteúdo
     */
    public function editar(Request $request, int $id) {
        $request->validate([
            'campo'  => 'required',
            'valor'  => 'required',
        ]);

        Contato::where('id', $id)->update($request->except(['_token']));

        return redirect()->route('contatos.listar')->with(['sucesso' => 'Contato editado com sucesso']);
    }
    
    /** Remove um conteúdo
     * @param $id id do conteúdo
     */
    public function excluir(int $id) {
        Contato::destroy($id);
        return redirect()->route('contatos.listar')->with('sucesso', 'Contato excluido');
    }
}
