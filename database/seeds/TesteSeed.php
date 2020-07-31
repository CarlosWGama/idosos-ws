<?php

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class TesteSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //Nutrição
        Usuario::create([
            'nome'  => 'Nutrição Prof',
            'senha' => md5('123456'),
            'admin' => true,
            'profissao_id' => 2,
            'nivel_acesso' => 1
        ]);

        Usuario::create([
            'nome'  => 'Nutrição Mod',
            'senha' => md5('123456'),
            'admin' => false,
            'profissao_id' => 2,
            'nivel_acesso' => 2
        ]);

        Usuario::create([
            'nome'  => 'Nutrição Aluno',
            'senha' => md5('123456'),
            'admin' => false,
            'profissao_id' => 2,
            'nivel_acesso' => 3
        ]);
        
        //Nutrição
        Usuario::create([
            'nome'  => 'EduFis Prof',
            'senha' => md5('123456'),
            'admin' => true,
            'profissao_id' => 5,
            'nivel_acesso' => 1
        ]);

        Usuario::create([
            'nome'  => 'EduFis Mod',
            'senha' => md5('123456'),
            'admin' => false,
            'profissao_id' => 5,
            'nivel_acesso' => 2
        ]);

        Usuario::create([
            'nome'  => 'EduFis Aluno',
            'senha' => md5('123456'),
            'admin' => false,
            'profissao_id' => 5,
            'nivel_acesso' => 3
        ]);
    }
}
