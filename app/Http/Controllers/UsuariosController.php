<?php

namespace App\Http\Controllers;

use App\Models\Profissao;
use Illuminate\Http\Request;
use App\Models\Usuario;

/**
 * Controller responsável pela manipulação dos dados do usuários 
 */
class UsuariosController extends Controller {
    
    private $dados = ['menu' => 'usuarios'];

    /** Lista o usuários */
    public function index() {
        $this->dados['usuarios'] = Usuario::where('deletado', false)->with('Profissao')->paginate(10);
        return view('usuarios.listar', $this->dados);
    }

    /** 
     * Abre a tela cadastrar novo usuário
     */
    public function novo() {
        $this->dados['usuario'] = new Usuario;
        $this->dados['profissoes'] = Profissao::all();
        return view('usuarios.novo', $this->dados);
    }

    /** 
     * Tenta salvar um novo usuário
     */
    public function cadastrar(Request $request) {
        $request->validate([
            'nome'  => 'required',
            'senha'  => 'required|min:6',
        ]);
        $dados = $request->all();
        $dados['senha'] = md5($dados['senha']);
        $usuario = Usuario::create($dados);

        return redirect()->route('usuarios.listar')->with(['sucesso' => 'Usuário cadastrado com sucesso. Código de acesso: ' . $usuario->id]);
    }

    /** 
     * Abre a tela de editar usuário
     * @param $id id do usuário
     */
    public function edicao(int $id) {
        $this->dados['usuario'] = Usuario::where('id',$id)->where('deletado', false)->firstOrFail();
        $this->dados['profissoes'] = Profissao::all();

        return view('usuarios.edicao', $this->dados);
    }
    
    /** Tenta editar um usuário e salvar no banco
     * @param $id id do usuário
     */
    public function editar(Request $request, int $id) {
        $request->validate([
            'nome'  => 'required',
        ]);

        $dados = $request->except(['_token']);
        if (!empty($dados['senha']))
            $dados['senha'] = md5($dados['senha']);
        else unset($dados['senha']);
        Usuario::where('id', $id)->update($dados);

        return redirect()->route('usuarios.listar')->with(['sucesso' => 'Usuário editado com sucesso']);
    }
    
    /** Remove um usuário
     * @param $id id do usuário
     */
    public function excluir(int $id) {
        // Usuario::destroy($id);
        $usuario = Usuario::findOrFail($id);
        $usuario->deletado = true;
        $usuario->save();
        return redirect()->route('usuarios.listar')->with('sucesso', 'Usuário excluido');
    }
}
