<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Firebase\JWT\JWT;

class FarmaciaMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $areaID = 7;
        $dados = JWT::decode($request->header('Authorization'), config('jwt.senha'), ['HS256']);
        $usuarioID = $dados->id;
        $usuario = Usuario::where('id', $usuarioID)->where('deletado', false)->firstOrFail();

        //Não é da area
        if ($usuario->profissao_id != $areaID)
            return response()->json(['Apenas profissionais de farmácia podem manipular esse produto'], 403);

        return $next($request);
    }
}
