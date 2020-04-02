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
            ['nome'  => 'Geral', 'exibir'=>false],
            ['nome'  => 'Nutricionista', 'exibir'=>true],
        ]);
    }
}
