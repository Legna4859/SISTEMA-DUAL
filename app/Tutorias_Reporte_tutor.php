<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Tutorias_Reporte_tutor extends Model
{
    protected $table = "reporte_tutor";
    protected $primaryKey = "id_reporte_tutor";
    public $timestamps = false;
    protected $fillable = ["id_asigna_generacion", "alumno","appaterno","apmaterno","n_cuenta","tutoria_grupal",
        "tutoria_individual","beca","repeticion","especial","academico","medico","psicologico",
        "baja","observaciones"];
}
