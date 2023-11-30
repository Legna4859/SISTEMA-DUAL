<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class Dual_Mentor_Calificaciones extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_periodo=Session::get('periodotrabaja');
        $id_carrera=Session::get('carrera');
        $usuario = Session::get('usuario_alumno');
        $periodo=Session::get('periodo_actual');
        //checar si el periodo esta activo
        $periodo_actual = DB::selectOne('SELECT *from gnral_periodos WHERE  estado = 1');
        $id_periodo_actual=$periodo_actual->id_periodo;
        if( $periodo == $id_periodo_actual ){
            $periodo_activo=1;
        }else{
            $periodo_activo=0;
        }
        $mentores_duales = DB::selectOne('SELECT gnral_personales.id_personal FROM gnral_personales WHERE gnral_personales.id_personal = gnral_personales.id_personal AND gnral_personales.tipo_usuario = '.$usuario.' ');

        /*$datos_registros = DB::select('SELECT eva_validacion_de_cargas.id, eva_validacion_de_cargas.id_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre, gnral_alumnos.apaterno,gnral_alumnos.amaterno,gnral_personales.nombre as profesor,abreviaciones.titulo, cal_duales_actuales.*
        FROM cal_duales_actuales, gnral_personales, gnral_alumnos, abreviaciones_prof, abreviaciones,eva_validacion_de_cargas 
        WHERE gnral_alumnos.id_alumno = cal_duales_actuales.id_alumno 
          AND cal_duales_actuales.id_personal = gnral_personales.id_personal 
          AND gnral_personales.id_personal = abreviaciones_prof.id_personal 
          AND abreviaciones_prof.id_abreviacion 
          AND abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion 
          AND cal_duales_actuales.id_periodo = '.$id_periodo.' 
          AND gnral_personales.id_personal = '.$mentores_duales->id_personal.' 
          AND  cal_duales_actuales.id_periodo = eva_validacion_de_cargas.id_periodo
          AND cal_duales_actuales.id_alumno = eva_validacion_de_cargas.id_alumno');*/

        $datos_registros = DB::select('SELECT
        MAX(eva_validacion_de_cargas.id) AS id,
        MAX(eva_validacion_de_cargas.id_alumno) AS id_alumno,
        MAX(gnral_alumnos.cuenta) AS cuenta,
        MAX(gnral_alumnos.nombre) AS nombre,
        MAX(gnral_alumnos.apaterno) AS apaterno,
        MAX(gnral_alumnos.amaterno) AS amaterno,
        MAX(gnral_personales.nombre) AS profesor,
        MAX(abreviaciones.titulo) AS titulo
        FROM cal_duales_actuales
        JOIN gnral_alumnos ON gnral_alumnos.id_alumno = cal_duales_actuales.id_alumno
        JOIN gnral_personales ON gnral_personales.id_personal = cal_duales_actuales.id_personal
        JOIN abreviaciones_prof ON gnral_personales.id_personal = abreviaciones_prof.id_personal
        JOIN abreviaciones ON abreviaciones_prof.id_abreviacion = abreviaciones.id_abreviacion
        JOIN eva_validacion_de_cargas ON cal_duales_actuales.id_alumno = eva_validacion_de_cargas.id_alumno
        WHERE cal_duales_actuales.id_periodo = '.$id_periodo.' 
        AND gnral_personales.id_personal = '.$mentores_duales->id_personal.'
        AND cal_duales_actuales.id_periodo = eva_validacion_de_cargas.id_periodo
        AND cal_duales_actuales.id_alumno = eva_validacion_de_cargas.id_alumno
        GROUP BY eva_validacion_de_cargas.id_alumno;');


        return view("duales.Mentor_Dual_Calificar.calificar_duales",compact('datos_registros','mentores_duales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
