<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DadosClinicos extends Model {
    
    use SoftDeletes;
    
    protected $table = 'dados_clinicos';
    
    //Não protege nenhum campo
    protected $guarded = [];

    //Não exibe esses campos
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['condicoes_clinicas'];


    public function condicoesClinicas() {
        return $this->belongsToMany('App\Models\CondicaoClinica', 'dados_clinicos_condicoes_clinicas', 'dados_clinicos_id', 'condicao_clinica_id');
    }

    public function getCondicoesClinicasAttribute() {
        $dados = DB::table('dados_clinicos_condicoes_clinicas')->where('dados_clinicos_id', $this->id)->get('condicao_clinica_id');
        $condicoes = [];
        foreach ($dados as $c) $condicoes[] = $c->condicao_clinica_id;
        return $condicoes;
    }

    public function getCondicoesAttributos() {

    }
}
