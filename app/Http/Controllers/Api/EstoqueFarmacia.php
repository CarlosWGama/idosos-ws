<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FarmaciaMaterial;
use App\Models\FarmaciaRemedio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstoqueFarmacia extends ApiController {

    protected $areaID = 7;

    public function __construct() {
        $this->middleware('farmacia')->except('buscar');
    }

    //
    // =========================== PRODUTOS =============================== //
    /** 
     * Busca os produtos
     * @param $tipo = remedios ou materiais
     */
    public function buscar(Request $request, string $tipo,  int $inicio = 0, int $limite = 10) {
        $model = ($tipo == 'remedios' ? FarmaciaRemedio::query() : FarmaciaMaterial::query());
        $produtos =  $model->offset($inicio)->limit($limite)->orderBy('nome', 'asc')->get();
        return response()->json(['produtos' => $produtos], 200);
    }
    
    /** 
     * Cadastra Produto
     * @param $tipo => remedios ou materiais
     */
    public function cadastrar(Request $request, string $tipo) {

        $validation = Validator::make($request->dados, [           
            'nome'                       => 'required',
            'forma_farmaceutica'         => 'integer|nullable',
            'quantidade'                 => 'integer|nullable',
            'saida'                      => 'integer|nullable',
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Cadastra
        $dados = $request->dados;
        if (!empty($dados['validade'])) $dados['validade'] = date('Y-m-d', strtotime($dados['validade']));
        
        $produto = ($tipo == 'remedios' ? FarmaciaRemedio::create($dados) : FarmaciaMaterial::create($dados));
        return response()->json($produto, 200);
    }

    /** 
     * Atualiza produto
     * @param $tipo = remedios ou materiais 
     */
    public function atualizar(Request $request, string $tipo, int $produtoID) {
        //Seleciona o Model
        $model = ($tipo == 'remedios' ? FarmaciaRemedio::query() : FarmaciaMaterial::query());
        $produto = $model->findOrFail($produtoID);
               
        //Validação
        $validation = Validator::make($request->dados, [
            'nome'                       => 'required',
            'forma_farmaceutica'         => 'integer|nullable',
            'quantidade'                 => 'integer|nullable',
            'saida'                      => 'integer|nullable',
        ]);

        if ($validation->fails()) return response()->json($validation->errors(), 400);

        //Atualiza
        $dados = $request->dados;
        if (!empty($dados['validade'])) $dados['validade'] = date('Y-m-d', strtotime($dados['validade']));
        $produto->fill($dados);
        $produto->save();

        return response()->json(['produto' => $produto], 200);
    }

    /**
     * Exclui um produto
     * @param $tipo = remedios ou materiais
    */
     public function excluir(Request $request, string $tipo, int $produtoID) {
        //Seleciona o Model
        $model = ($tipo == 'remedios' ? FarmaciaRemedio::query() : FarmaciaMaterial::query());
       
        $produto = $model->findOrFail($produtoID);
        $produto->delete();

        return response()->json('Produto excluído', 200);
    }

}
