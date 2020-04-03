<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foto extends Model
{
    use SoftDeletes;
    
    //Não protege nenhum campo
    protected $guarded = [];

    //Carrega automaticamente atributos customizados
    protected $appends = ['url'];

    //Esconde os campos
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Altera para a imagem ser exibida com a URL inteira.
     */
    public function getUrlAttribute() {
        return url('storage/fotos/'.$this->arquivo);        
    }
}
