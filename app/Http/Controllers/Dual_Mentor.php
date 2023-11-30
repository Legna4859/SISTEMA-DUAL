<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class Dual_Mentor extends Controller
{
    public function index()
    {
        $id_periodo = Session::get('periodotrabaja');
        $id_carrera = Session::get('carrera');
        $id_periodo_carrera = DB::selectOne('SELECT id_periodo_carrera FROM gnral_periodo_carreras WHERE id_periodo='.$id_periodo.' AND id_carrera='.$id_carrera.'');
        $id_periodo_carrera=$id_periodo_carrera->id_periodo_carrera;
        $docentes = DB::select('SELECT gnral_personales.id_personal,gnral_personales.nombre FROM
                                gnral_personales, gnral_horarios WHERE
                                gnral_horarios.id_periodo_carrera = '.$id_periodo_carrera.' AND
                                gnral_horarios.id_personal = gnral_personales.id_personal');
       // dd($docentes);
        $estudiantes=DB::select('SELECT eva_validacion_de_cargas.id, eva_validacion_de_cargas.id_alumno,
        gnral_alumnos.cuenta, gnral_alumnos.nombre,gnral_alumnos.apaterno, gnral_alumnos.amaterno, 
        gnral_carreras.nombre carreras, gnral_semestres.descripcion semestre 
        FROM eva_validacion_de_cargas, gnral_alumnos, 
        gnral_carreras, gnral_semestres, cal_duales_actuales 
        WHERE eva_validacion_de_cargas.id_periodo = 28
        AND cal_duales_actuales.id_alumno = eva_validacion_de_cargas.id_alumno
        AND eva_validacion_de_cargas.id_periodo = cal_duales_actuales.id_periodo
        AND eva_validacion_de_cargas.estado_validacion = 8 
        AND eva_validacion_de_cargas.id_alumno=gnral_alumnos.id_alumno 
        AND gnral_alumnos.id_carrera=gnral_carreras.id_carrera 
        AND gnral_alumnos.id_semestre = gnral_semestres.id_semestre
        AND gnral_carreras.id_carrera = 2
        AND gnral_alumnos.id_alumno NOT IN (SELECT cal_duales_actuales.id_alumno FROM cal_duales_actuales 
        WHERE cal_duales_actuales.id_periodo = 28 AND cal_duales_actuales.id_personal > 0)
        ');
        //dd($estudiantes);
        $datos = DB::select('SELECT gnral_alumnos.nombre,gnral_alumnos.cuenta, gnral_alumnos.apaterno,gnral_alumnos.amaterno, gnral_personales.nombre as profesor, 
       abreviaciones.titulo, cal_duales_actuales.* 
        FROM cal_duales_actuales, gnral_personales, gnral_alumnos, abreviaciones_prof, abreviaciones 
        WHERE gnral_alumnos.id_alumno = cal_duales_actuales.id_alumno 
          AND cal_duales_actuales.id_personal = gnral_personales.id_personal 
          AND gnral_personales.id_personal = abreviaciones_prof.id_personal 
          AND abreviaciones_prof.id_abreviacion 
          AND abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion 
          AND cal_duales_actuales.id_periodo = '.$id_periodo.' 
          AND gnral_alumnos.id_carrera='.$id_carrera.'');

        //dd($datos);
        return view('duales.Agregar_docentes_duales', compact('estudiantes','docentes','datos'));
    }

    public function guardar_mentor_dual(Request $request){
        $id_periodo = Session::get('periodotrabaja');
        $this->validate($request,[
            'id_profesor' => 'required',
            'id_alumno' => 'required',
        ]);
        $id_profesor = $request->input("id_profesor");
        $id_alumno = $request->input("id_alumno");

        DB:: table('cal_duales_actuales')
            ->insert([
                'id_personal' =>$id_profesor,
                'id_alumno' =>$id_alumno,
                'id_periodo' =>$id_periodo
            ]);
        return back();

    }

    public function eliminar_alumno_dual(Request $request, $id_duales_actuales)
    {
        //dd($id_duales_actuales);
        DB::delete('DELETE FROM cal_duales_actuales WHERE id_duales_actuales='.$id_duales_actuales.'');
        return back();
    }
}
