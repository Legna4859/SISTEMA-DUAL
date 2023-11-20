<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
       	protected $table = 'gnral_municipios';
   		protected $primaryKey='id_municipio';
   		protected $fillable=['nombre_municipio','id_estado'];


}
