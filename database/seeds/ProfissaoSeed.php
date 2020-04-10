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
            ['id' => 1, 'nome'  => 'Geral', 'exibir'=>false],
            ['id' => 2, 'nome'  => 'Nutricionista', 'exibir'=>true],
            ['id' => 3, 'nome'  => 'Dentista', 'exibir'=>true],
        ]);
    }
}
