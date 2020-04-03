<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use Firebase\JWT\JWT;

/**
 * @package API
 * Classe responsável por Controlar as requisições da API envolvendo usuário
 */
class UsuariosController extends ApiController {
    
    /** Loga o usuário */
    public function logar(Request $request) {
        $usuario = Usuario::where('id', $request->codigo)
                            ->where('senha', md5($request->senha))
                            ->firstOrFail(); //Senão achar retorna 404

        $jwt = JWT::encode(['id' => $usuario->id], config('jwt.senha'));
        return response()->json(['jwt' => $jwt, 'usuario' => $usuario], 200);
    }


    /** Cadastra um novo usuário */
    public function registrar(Request $request) {

        $validation = Validator::make($request->usuario, [
            'nome'  => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|min:6'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        } else {
            $usuario = $request->usuario;
            $usuario['senha'] = md5($usuario['senha']);
            $usuario = Usuario::create($usuario);
            return response()->json($usuario, 201);
        }
    }
}
