<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacao extends Model
{
    //
    protected $table = 'notificacoes';

    use SoftDeletes;

    //Não protege nenhum campo
    protected $guarded = [];

    //Esconde os campos
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
    //Sempre traz
    protected $with = ['paciente', 'autor'];
    
    //Adiciona data cadastro
    protected $appends = ['data_cadastro'];

    public function getDataCadastroAttribute() {
        return date('Y-m-d', strtotime($this->attributes['created_at']));
    }

    //Retorna dados do usuário que cadastrou a notificação
    public function autor() {
        return $this->belongsTo('App\Models\Usuario', 'autor_id');
    }
    
    //Retorna dados do paciente 
    public function paciente() {
        return $this->belongsTo('App\Models\Paciente', 'paciente_id');
    }

    //Retorna dados do usuário que cadastrou o prontuário
    public function destinatarios() {
        return $this->hasMany('App\Models\NotificacaoDestinatario', 'notificacao_id');
    }
}
