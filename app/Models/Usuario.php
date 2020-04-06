<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model {

    use SoftDeletes;
    
    //Não protege nenhum campo
    protected $guarded = [];

    //Não exibe esses campos
    protected $hidden = ['senha', 'deletado','created_at', 'updated_at', 'deleted_at'];

    /**
     * Retorna os dados do nível do usuário
     * Inner Join
     */
    public function profissao() {
        return $this->belongsTo('App\Models\Profissao', 'profissao_id');
    }

}
