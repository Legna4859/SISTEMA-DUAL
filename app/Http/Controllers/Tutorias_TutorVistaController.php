<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class Tutorias_TutorVistaController extends Controller
{
    //
    public function index(Request $request)
    {
        /*$semestre=DB::select('select DISTINCT gnral_semestres.id_semestre,DATE_FORMAT(planeacion.fecha_inicio_sesion, "%d-%m-%Y") as fecha_inicio,DATE_FORMAT(fecha_fin_sesion, "%d-%m-%Y") as fecha_fin,planeacion.*
                                from gnral_semestres,gnral_alumnos,exp_asigna_alumnos,exp_asigna_tutor,exp_asigna_generacion,
                                gnral_personales,users,planeacion
                                where gnral_semestres.id_semestre=gnral_alumnos.id_semestre
                                and planeacion.id_semestre=gnral_alumnos.id_semestre
                                and planeacion.id_estado=1
                                and gnral_alumnos.id_alumno=exp_asigna_alumnos.id_alumno
                                and exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                                and exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                                and exp_asigna_tutor.id_personal=gnral_personales.id_personal
                                and gnral_personales.tipo_usuario=users.id
                                and users.id='.Auth::user()->id);

        $tutor=DB::select('select DISTINCT gnral_personales.nombre,gnral_personales.id_personal        
                                from gnral_semestres,gnral_alumnos,exp_asigna_alumnos,exp_asigna_tutor,exp_asigna_generacion,
                                gnral_personales,users,planeacion
                                where gnral_semestres.id_semestre=gnral_alumnos.id_semestre
                                and planeacion.id_semestre=gnral_alumnos.id_semestre
                                and planeacion.id_estado=1
                                and gnral_alumnos.id_alumno=exp_asigna_alumnos.id_alumno
                                and exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                                and exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                                and exp_asigna_tutor.id_personal=gnral_personales.id_personal
                                and gnral_personales.tipo_usuario=users.id
                                and users.id='.Auth::user()->id);
        $semestre1=Gnral_semestre::all();
        $areas=areas_canalizacion::all();*/
        return view('tutorias.profesor.index');
    }
}
