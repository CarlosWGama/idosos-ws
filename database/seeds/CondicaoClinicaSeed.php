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
            ['id' => 1, 'condicao' => 'Sem Doenças'],
            ['id' => 2, 'condicao' => 'Hipertensão'],
            ['id' => 3, 'condicao' => 'Diabetes'],
            ['id' => 4, 'condicao' => 'DCV'],
            ['id' => 5, 'condicao' => 'IAM'],
            ['id' => 6, 'condicao' => 'AVC'],
            ['id' => 7, 'condicao' => 'Pé Diabético'],
            ['id' => 8, 'condicao' => 'Doença Renal'],
            ['id' => 9, 'condicao' => 'Diabetas Tipo 1'],
            ['id' => 10, 'condicao' => 'Diabetas Tipo 2']
        ]);
    }
}
