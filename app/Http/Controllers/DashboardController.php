<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
/**
 * Tela Inicial do Admin
 */
class DashboardController extends Controller {
    private $dados = ['menu' => 'dashboard'];

    /** Tela Inicial do Dashboard */
    public function index() {
        $this->dados['usuariosCadastrados'] = Usuario::count();
        $this->dados['pacientesCadastrados'] = 0;
        return view('dashboard.index', $this->dados);
    }
}
