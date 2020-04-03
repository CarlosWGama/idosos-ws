<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model {
    use SoftDeletes;
    
    //Não protege nenhum campo
    protected $guarded = [];

    //Não exibe esses campos
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Retorna os dados do usuário dono da Evento
     * Inner Join
     */
    public function autor() {
        return $this->belongsTo('App\Models\Usuario', 'autor_id');
    }
}
