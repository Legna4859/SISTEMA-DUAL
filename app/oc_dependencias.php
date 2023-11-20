<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class oc_dependencias extends Model
{
    protected $table='oc_depend_domicilio';
    protected $primaryKey='id_depend_domicilio';
    protected $fillable=['dependencia','domicilio','id_oficio',	'id_municipio'];
}
