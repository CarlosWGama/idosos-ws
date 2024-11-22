<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware {
   
    public function handle(Request $request, Closure $next)
    {
        if (session('usuario'))
            return $next($request);
        return redirect('login')->with('erro', 'Necessário estar autenticado');
    }
}
