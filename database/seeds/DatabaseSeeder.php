<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProfissaoSeed::class);
        $this->call(UsuarioSeed::class);
        $this->call(HistoricoSeed::class);
        $this->call(CondicaoClinicaSeed::class);
    }
}
