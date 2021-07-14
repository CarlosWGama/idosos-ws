<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExameLaboratorial extends Model {
    //

    use SoftDeletes;

    protected $table = 'exames_laboratoriais';

    //Não protege nenhum campo
    protected $guarded = [];

    //Esconde os campos
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
    //Sempre traz
    protected $with = ['criador', 'modificado_por'];

    //Retorna dados do usuário que cadastrou o exame clínico
    public function criador() {
        return $this->belongsTo('App\Models\Usuario', 'criado_por');
    }

    //Retorna dados do usuário que alterou o exame clínico por ultimo
    public function modificado_por() {
        return $this->belongsTo('App\Models\Usuario', 'modificado_por');
    }
}
