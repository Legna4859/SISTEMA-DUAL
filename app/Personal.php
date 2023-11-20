<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Personal extends Model
{
    protected $table = 'gnral_personales';
    protected $primaryKey='id_personal';
    protected $fillable=['nombre','id_perfil','id_situacion','esc_procedencia','origen_nac','fch_nac',
    					'direccion','fch_ingreso_tesvb','nombramiento','rfc','fch_recontratacion',
    					'escolaridad','id_cargo','clave','horas_maxima','correo','telefono','celular',
    					'cedula','sexo','maximo_horas_ingles','abreviacion','id_departamento','tipo_usuario'];

    public static function getAllProf(){

        $profesores=DB::select('SELECT gnral_personales.id_personal, gnral_personales.nombre 
          FROM gnral_personales 
          ORDER BY gnral_personales.nombre');
        return $profesores;
    }

}