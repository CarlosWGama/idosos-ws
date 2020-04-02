<?php

use App\Models\QuemSomos;
use Illuminate\Database\Seeder;

class HistoricoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        QuemSomos::create([
            'descricao' => ' <h1>Início</h1>
            <p>Fundada em 1995...</p>
            <p>Atuamente conta com x profissioanis...</p>
            <p>Possuímos y idosos...</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc iaculis sollicitudin metus, ac dapibus est commodo eget. Sed a convallis ipsum. In hac habitasse platea dictumst. Donec at metus ut magna fermentum tristique. Duis aliquam lorem in vestibulum gravida. Cras ligula risus, lacinia mattis pulvinar id, vestibulum sit amet nibh. Sed vel tincidunt nibh, sed dignissim massa. Phasellus hendrerit magna ut nibh hendrerit, vel iaculis enim dapibus. Nam aliquam in lectus eu molestie.</p>'
        ]);
    }
}
