<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificacaoDestinatario extends Model {
    
    use SoftDeletes;
    
    //
    protected $table = 'notificacoes_destinatarios';

    //Não protege nenhum campo
    protected $guarded = [];

    //Esconde os campos
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
    //Sempre traz
    protected $with = ['destinatario', 'notificacao'];

    //Retorna dados do usuário que cadastrou a notificação
    public function destinatario() {
        return $this->belongsTo('App\Models\Usuario');
    }
    
    //Retorna dados do usuário que cadastrou a notificação
    public function notificacao() {
        return $this->belongsTo('App\Models\Notificacao');
    }
}
