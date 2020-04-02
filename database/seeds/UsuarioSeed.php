<?php

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Usuario::create([
            'nome'  => 'Admin',
            'senha' => md5('123456'),
            'admin' => true,
            'profissao_id' => 1,
            'nivel_acesso' => 1
        ]);
    }
}
