<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Classe responsável por controlar rotas autenticadas.
 */
class JWTMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        try {
            $jwt = $request->bearerToken();
            $dados = JWT::decode($jwt,new Key(config('jwt.senha'), 'HS256'));
            
            return $next($request);
        } catch (\Exception $e) { 
            //Adicionar \ antes no Exception, porque estamos no namespace App\Http\Middleware
            //Do contrário ele vai procura Exception nesse caminho. 
            return response()->json(['erro' => 'Token inválido'], 403);
        }
    }
}
