<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OdontoProntuario extends Model {
//

   use SoftDeletes;

   protected $table = 'odonto_prontuarios';

   //Não protege nenhum campo
   protected $guarded = [];

   //Esconde os campos
   protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
