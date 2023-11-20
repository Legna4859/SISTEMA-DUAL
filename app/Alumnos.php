<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    protected $table = 'gnral_alumnos';
    protected $primaryKey='id_alumno';
    protected $fillable=[
                    'cuenta',
                'nombre',
                'apaterno',
                'amaterno',
                'genero',
                'fecha_nac',
                'edad',
                'curp_al',
                'edo_civil',
                'nacionalidad',
                'twiter_al',
                'correo_al',
                'facebook_al',
                'cel_al',
                'tel_fijo_al',
                'entidad_nac_al',
                'grado_estudio_al',
                'id_carrera',
                'id_semestre',
                'grupo',
                'promedio',
                'estado',
                'id_municipio',

                'calle_al',
                'n_ext_al',
                'n_int_al',
                'entre_calle',
                'y_calle',
                'otra_ref',
                'colonia_al',
                'localidad_al',
                'cp',
                'id_usuario',
                'discapacidad',
        'descripcion_discapacidad',
        'lengua',
        'descripcion_lengua',
        'id_seguro_social',
        'numero_seguro_social',
        'id_escuela_procedencia',
        'promedio_preparatoria',
        's_a',
                             ];
    public static function getAlumnos(){
        $datos=DB::select('select a.id_alumno,a.nombre,a.apaterno,a.amaterno,g.grupo,gnral_carreras.siglas 
                           from gnral_alumnos as a, gnral_carreras,gnral_grupos as g, asigna_tutor as a_t
                           where a.id_carrera=gnral_carreras.id_carrera and a.grupo=g.id_grupo and a.id_carrera=a_t.id_carrera and a.id_semestre=a_t.id_semestre and a.grupo=a_t.id_grupo;');
        return $datos;
    }

    public static function getAlumno(){
        $datos=DB::select('select a.nombre,a.apaterno,a.amaterno,s.descripcion,c.siglas,a.grupo, p.nombre,p.correo
                           from gnral_alumnos as a, gnral_carreras as c, gnral_personales as p, asigna_tutor as ast, gnral_semestres as s
                           where a.id_carrera=c.id_carrera and ast.id_grupo=a.grupo and ast.id_carrera=c.id_carrera and ast.id_semestre=s.id_semestre and p.id_personal=ast.id_personal');
        return $datos;
    }
}
