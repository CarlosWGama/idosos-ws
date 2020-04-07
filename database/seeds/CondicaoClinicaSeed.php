<?php

use App\Models\CondicaoClinica;
use Illuminate\Database\Seeder;

class CondicaoClinicaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CondicaoClinica::insert([
            ['condicao' => 'Sem Doenças'],
            ['condicao' => 'Hipertensão'],
            ['condicao' => 'Diabetes'],
            ['condicao' => 'DCV'],
            ['condicao' => 'Câncer']
        ]);
    }
}
