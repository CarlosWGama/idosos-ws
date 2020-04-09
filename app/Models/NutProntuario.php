<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class NutProntuario extends Model
{
    
   use SoftDeletes;

   protected $table = 'prontuarios_nutricao';

   //Não protege nenhum campo
   protected $guarded = [];

   //Esconde os campos
   protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

   protected $appends = ['saude_gastrointestinal', 'membro_amputado'];

   //Retorna dados do usuário que cadastrou o prontuário
   public function usuario() {
      return $this->belongsTo('App\Models\Usuario');
   }
    
   //Recupera ação com Saude Gastrointestinal
   public function saudeGastrointestinal() {
      return $this->belongsToMany('App\Models\NutSaudeGastrointestinal', 'prontuarios_nutricao_saude_gastrointestinal', 'prontuario_id', 'saude_gastroinstestinal_id');
   }

   public function getSaudeGastrointestinalAttribute() {
      $dados = DB::table('prontuarios_nutricao_saude_gastrointestinal')->where('prontuario_id', $this->id)->get('saude_gastroinstestinal_id');
      $condicoes = [];
      foreach ($dados as $c) $condicoes[] = $c->saude_gastroinstestinal_id;
      return $condicoes;
   }

   //Recupera ação com Membros Amputados
   public function membroAmputado() {
      return $this->belongsToMany('App\Models\NutMembroAmputado', 'prontuarios_nutricao_membros_amputados', 'prontuario_id', 'membro_id');
   }

   public function getMembroAmputadoAttribute() {
      $dados = DB::table('prontuarios_nutricao_membros_amputados')->where('prontuario_id', $this->id)->get('membro_id');
      $condicoes = [];
      foreach ($dados as $c) $condicoes[] = $c->membro_id;
      return $condicoes;
   }

}
