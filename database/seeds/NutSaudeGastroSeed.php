<?php

use App\Models\NutSaudeGastrointestinal;
use Illuminate\Database\Seeder;

class NutSaudeGastroSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NutSaudeGastrointestinal::insert([
            ['id' => 1 , 'descricao' => 'Azia'],
            ['id' => 2 , 'descricao' => 'Refluxo'],
            ['id' => 3 , 'descricao' => 'Distensão Abdominal'],
            ['id' => 4 , 'descricao' => 'Náuseas e vômitos'],
            ['id' => 5 , 'descricao' => 'Constipação'],
            ['id' => 6 , 'descricao' => 'Diarréia'],
            ['id' => 7 , 'descricao' => 'Flatulência'],
            ['id' => 8 , 'descricao' => 'Mastigação inadequada'],
            ['id' => 9 , 'descricao' => 'Disfagia']
        ]);
    }
}
