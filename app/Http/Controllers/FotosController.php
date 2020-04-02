<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Http\Request;

class FotosController extends Controller
{
   /**
    * Abre a tela com a listagem de Fotos e permitir cadastrar novas fotos
    */
    public function index() {
        $this->dados['fileupload'] = true;
        $this->dados['fotos'] = Foto::paginate(20);
        return view('fotos.index', $this->dados);
    }

    /**
    * Cadastrar novas fotos
    */
    public function cadastrar(Request $request) {
        $request->validate([
            'legenda'  => 'required', 
            'arquivo' => 'required|image|file|max:2048'
        ]);
        $foto = Foto::create($request->all());

        //Upload da imagem
        $extensao = $request->arquivo->extension();
        $arquivo = 'foto_'.$foto->id.'.'.$extensao;
        $request->arquivo->storeAs('public/fotos', $arquivo);
        $foto->arquivo = $arquivo;
        $foto->save();

        return redirect()->route('casa.fotos')->with(['sucesso' => 'Foto cadastrada com sucesso']);
    }

    /** Remove um usuário
     * @param $id id do usuário
     */
    public function excluir(int $id) {
        Foto::destroy($id);
        return redirect()->route('casa.fotos')->with('sucesso', 'Foto excluida');
    }
}
