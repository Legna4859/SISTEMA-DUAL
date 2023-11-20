<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorias_Planeacion extends Model
{
    protected $table ="planeacion";
    protected $primaryKey="id_planeacion";
    public $timestamps = false;
    protected $fillable=["fecha_inicio","fecha_fin","desc_actividad","objetivo","instrucciones","id_semestre","id_estado","comentarios","sugerencia","id_sugerencia"];


}
