<?php

use Illuminate\Database\Seeder;
use App\Models\Profissao;

class ProfissaoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Profissao::insert([
            ['id' => 1, 'nome'  => 'Geral',                             'exibir'=>false],
            ['id' => 2, 'nome'  => 'Nutricionista',                     'exibir'=>true],
            ['id' => 3, 'nome'  => 'Dentista',                          'exibir'=>true],
            ['id' => 4, 'nome'  => 'Fisioterapeuta',                    'exibir'=>true],
            ['id' => 5, 'nome'  => 'Profissional de Educação Física',   'exibir'=>true],
            ['id' => 6, 'nome'  => 'Profissional de Enfermagem',        'exibir'=>true],
        ]);
    }
}
