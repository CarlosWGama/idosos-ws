<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model {
    use SoftDeletes;
    
    //Não protege nenhum campo
    protected $guarded = [];

    //Não exibe esses campos
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Altera para a imagem ser exibida com a URL inteira.
     */
    public function getFotoAttribute($value) {
        return url('storage/pacientes/'.$value);        
    }
}
