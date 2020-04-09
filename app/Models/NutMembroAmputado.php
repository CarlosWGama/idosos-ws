<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NutMembroAmputado extends Model
{
    use SoftDeletes;

    protected $table = 'nut_membros_amputados';

    //Não protege nenhum campo
    protected $guarded = [];

    //Esconde os campos
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
