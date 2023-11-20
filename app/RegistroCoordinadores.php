<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroCoordinadores extends Model
{
    protected $table = 'actcomple_registros_coordinadores';
    protected $primaryKey='id_reg_coordinador';
    protected $fillable=['vigencia','no_evidencias','rubrica','id_periodo_carrera','fecha_registro','id_docente_actividad','estado_evidencias'];

}
