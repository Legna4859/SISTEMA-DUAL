<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;
class Tutorias_asigna_tutor extends Model
{
    protected $table ="asigna_tutor";
    protected $primaryKey="id_asigna_tutor";
    protected $fillable=["id_personal","id_grupo","id_carrera","id_semestre"];

    public static function getDatos(){
        $datos=DB::select('SELECT c.id_carrera,c.nombre 
                           from gnral_carreras as c, asigna_tutor as ast, gnral_personales as p
                           WHERE ast.id_carrera=c.id_carrera and ast.id_personal=p.id_personal and p.id_personal=1 GROUP BY c.siglas;');
        return $datos;
    }

    public static function getDatosall(){
        $datos=DB::select('SELECT a.id_alumno,p.id_personal,p.nombre,p.correo,s.descripcion,s.id_semestre,g.grupo,g.id_grupo
                           FROM gnral_personales as p, gnral_semestres as s, gnral_grupos as g, asigna_tutor as ast,gnral_alumnos as a
                           where ast.id_personal=p.id_personal and ast.id_grupo=g.id_grupo and ast.id_semestre=s.id_semestre and a.id_semestre=s.id_semestre and a.grupo=g.id_grupo;');
        return $datos;
    }
    public static function getCarrera(){
        $datos=DB::select('SELECT a.id_alumno,a.nombre,a.apaterno,a.amaterno,c.id_carrera,c.siglas,s.descripcion,g.grupo,
p.id_personal 
FROM gnral_alumnos as a,gnral_carreras as c, gnral_semestres as s, gnral_grupos as g, asigna_tutor as ast, gnral_personales as p
WHERE a.id_semestre=s.id_semestre and a.grupo=g.id_grupo and a.id_carrera=c.id_carrera and ast.id_carrera=c.id_carrera and ast.id_semestre=s.id_semestre and ast.id_personal=p.id_personal and NOT EXISTS(SELECT null from canalizacion WHERE a.id_alumno=canalizacion.id_alumno);');
        return $datos;
    }
    public static function getCarrera1(){
        $datos=DB::select('SELECT can.id_canalizacion,a.id_alumno,a.nombre,a.apaterno,a.amaterno,c.id_carrera,c.siglas,s.descripcion,g.grupo,
p.id_personal 
FROM gnral_alumnos as a,gnral_carreras as c, gnral_semestres as s, gnral_grupos as g, asigna_tutor as ast, canalizacion as can, gnral_personales as p
WHERE a.id_semestre=s.id_semestre and a.grupo=g.id_grupo and a.id_carrera=c.id_carrera and ast.id_carrera=a.id_carrera and ast.id_semestre=a.id_semestre and ast.id_personal=p.id_personal and can.id_alumno=a.id_alumno and can.id_personal=p.id_personal;');
        return $datos;
    }

    public static function getAlumno(){
        $datos=DB::select('SELECT p.nombre,g.grupo,c.nombre,c.siglas,s.descripcion 
                           FROM gnral_personales as p,gnral_grupos as g,gnral_carreras as c,gnral_semestres as s, asigna_tutor as a_T
                           WHERE a_T.id_personal=p.id_personal and a_T.id_grupo=g.id_grupo and a_T.id_carrera=c.id_carrera and a_T.id_semestre=s.id_semestre and p.id_personal = 1;');
        return $datos;
    }

    public static function getCarreraG(){
        $datos=DB::select('SELECT c.id_carrera,c.nombre,s.descripcion,g.grupo,p.id_personal
                           FROM gnral_alumnos as a,gnral_carreras as c, gnral_semestres as s,gnral_grupos as g,asigna_tutor as ast,gnral_personales as p
                           WHERE a.id_carrera=c.id_carrera and a.id_semestre=s.id_semestre and a.grupo=g.id_grupo and ast.id_personal=p.id_personal and ast.id_grupo=g.id_grupo and ast.id_semestre=s.id_semestre and ast.id_grupo=g.id_grupo and p.id_personal=1;
        ');
        return $datos;
    }

    public static function getCarreraC(){
        $datos=DB::select('SELECT c.id_carrera,c.nombre 
                           from gnral_carreras as c, asigna_tutor as ast, gnral_personales as p
                           WHERE ast.id_carrera=c.id_carrera and ast.id_personal=p.id_personal GROUP BY c.siglas;');
        return $datos;
    }

    public static function getGrupo(){
        $datos=DB::select('SELECT g.id_grupo,g.grupo, c.id_carrera,ast.id_asigna_tutor
                           from gnral_grupos as g, asigna_tutor as ast,gnral_carreras as c
                           WHERE ast.id_grupo=g.id_grupo and ast.id_carrera=c.id_carrera ORDER BY c.siglas;');
        return $datos;
    }
}
