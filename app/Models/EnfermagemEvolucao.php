<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnfermagemEvolucao extends Model
{
    use SoftDeletes;

    protected $table = 'enfermagem_evolucoes';
 
    //Não protege nenhum campo
    protected $guarded = [];
 
    //Esconde os campos
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
    //Sempre traz
    protected $with = ['usuario'];

    //Retorna dados do usuário que cadastrou o prontuário
    public function usuario() {
        return $this->belongsTo('App\Models\Usuario');
    }
}
