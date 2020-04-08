<?php

use App\NutMembroAmputado;
use Illuminate\Database\Seeder;

class NutMembroAmputadoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        NutMembroAmputado::insert([
            ['id' => 1, 'descricao' => 'Mão'],
            ['id' => 2, 'descricao' => 'Antebraço'],
            ['id' => 3, 'descricao' => 'Braço até o ombro'],
            ['id' => 4, 'descricao' => 'Pé'],
            ['id' => 5, 'descricao' => 'Perna até o joelho'],
            ['id' => 6, 'descricao' => 'Perna inteira']
        ]);
    }
}
