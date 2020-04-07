<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CondicaoClinica extends Model {

    use SoftDeletes;
    
    protected $table = 'condicoes_clinicas';
    
    //Não protege nenhum campo
    protected $guarded = [];
}
