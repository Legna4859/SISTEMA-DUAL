<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;

class DatosHistoricosJefeController extends Controller
{

    public function index()
    {
        $usuario = Session::get('usuario');
        $carrera = Session::get('carrera');
        $periodo=Session::get('periodo_actual');

        $historico=DB::select('Select actcomple_registro_alumnos.id_registro_alumno,gnral_alumnos.cuenta,gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno,
                                        CONCAT(gnral_semestres.id_semestre,"0",gnral_grupos.id_grupo) grupo,abreviaciones.titulo,gnral_personales.nombre docente,actividades_complementarias.creditos,actividades_complementarias.descripcion,
                                        gnral_semestres.descripcion semestre,gnral_periodos.periodo, ROUND(AVG(actcomple_evaluaciones.calificacion)) promedio 
                                        from abreviaciones,abreviaciones_prof,actcomple_evaluaciones,gnral_alumnos,gnral_grupos,gnral_carreras,actividades_complementarias,actcomple_evidencias_alumno,gnral_periodo_carreras,gnral_semestres,actcomple_docente_actividad,actcomple_registro_alumnos,gnral_personales,gnral_periodos               
                                        where gnral_alumnos.grupo=gnral_grupos.id_grupo
                                        and actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                        and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                                        and actcomple_docente_actividad.id_actividad_comple=actividades_complementarias.id_actividad_comple
                                        and actcomple_evaluaciones.id_evidencia_alumno=actcomple_evidencias_alumno.id_evidencia_alumno
                                        and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno
                                        and actcomple_registro_alumnos.id_periodo=gnral_periodos.id_periodo
                                        and gnral_alumnos.id_carrera=gnral_carreras.id_carrera
                                        and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                        and gnral_carreras.id_carrera='.$carrera.'  
                                        and gnral_periodos.id_periodo='.$periodo.'  
                                         and actcomple_docente_actividad.id_periodo='.$periodo.'               
                                        and gnral_personales.id_personal=actcomple_docente_actividad.id_personal
                                        and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                        and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                        and actcomple_registro_alumnos.id_semestre=gnral_semestres.id_semestre
                                        and actcomple_evaluaciones.estado=1
                                        group by actcomple_registro_alumnos.id_registro_alumno,cuenta,nombre,amaterno,apaterno,grupo,docente,creditos,descripcion,
                                        semestre,periodo,abreviaciones.titulo');
   
        return view('actividades_complementarias.jefatura.datos_historicos',compact('historico'));
    }


    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
