<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventosController extends Controller {
    private $dados = ['menu' => 'casa-do-pobre'];

    /** Lista os conteúdos cadastrados */
    public function index() {
        $this->dados['eventos'] = Evento::paginate(10);
        return view('eventos.listar', $this->dados);
    }

    /** 
     * Abre a tela cadastrar novo conteúdo
     */
    public function novo() {
        $this->dados['evento'] = new Evento();
        return view('eventos.novo', $this->dados);
    }

    /** 
     * Tenta salvar um novo conteúdo
     */
    public function cadastrar(Request $request) {
        $request->validate([
            'descricao'  => 'required',
            'data'       => ($request->recorrente ? '' : 'required|date'),
        ]);
        $dados = $request->all();
        $dados['autor_id'] = session('usuario')->id;
        Evento::create($dados);

        return redirect()->route('eventos.listar')->with(['sucesso' => 'Evento cadastrado com sucesso']);
    }

    /** 
     * Abre a tela de editar conteudo
     * @param $id id do conteudo
     */
    public function edicao(int $id) {
        $this->dados['evento'] = Evento::findOrFail($id);
        return view('eventos.edicao', $this->dados);
    }
    
    /** Tenta editar um conteúdo e salvá-lo no banco
     * @param $id id do conteúdo
     */
    public function editar(Request $request, int $id) {
        $request->validate([
            'descricao'  => 'required',
            'data'       => ($request->recorrente ? '' : 'required|date'),
        ]);

        Evento::where('id', $id)->update($request->except(['_token']));

        return redirect()->route('eventos.listar')->with(['sucesso' => 'Evento editado com sucesso']);
    }
    
    /** Remove um conteúdo
     * @param $id id do conteúdo
     */
    public function excluir(int $id) {
        Evento::destroy($id);
        return redirect()->route('eventos.listar')->with('sucesso', 'Evento excluido');
    }
}
