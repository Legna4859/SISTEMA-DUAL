<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;

class CreditosSemestresController extends Controller
{
  
    public function index()

    {
        $usuario = Session::get('usuario');
        
        $historial_creditos=DB::select("select actividades_complementarias.descripcion ac,actividades_complementarias.creditos cre,gnral_semestres.descripcion semestre,abreviaciones.titulo,gnral_personales.nombre docente,
                                        ROUND(AVG(actcomple_evaluaciones.calificacion)) promedio
                                        from actividades_complementarias,gnral_alumnos,gnral_personales,gnral_semestres,actcomple_registro_alumnos,actcomple_evidencias_alumno,actcomple_evaluaciones,                                        
                                        actcomple_docente_actividad,abreviaciones,abreviaciones_prof
                                        where actividades_complementarias.id_actividad_comple=actcomple_docente_actividad.id_actividad_comple
                                        and actcomple_docente_actividad.id_docente_actividad=actcomple_registro_alumnos.id_docente_actividad
                                        and actcomple_docente_actividad.id_personal=gnral_personales.id_personal
                                        and abreviaciones_prof.id_abreviacion=abreviaciones.id_abreviacion
                                        and abreviaciones_prof.id_personal=gnral_personales.id_personal
                                        and actcomple_registro_alumnos.cuenta=gnral_alumnos.cuenta
                                        and actcomple_registro_alumnos.id_semestre=gnral_semestres.id_semestre
                                        and actcomple_evidencias_alumno.id_registro_alumno=actcomple_registro_alumnos.id_registro_alumno
                                        and actcomple_evidencias_alumno.id_evidencia_alumno=actcomple_evaluaciones.id_evidencia_alumno
                                        and gnral_alumnos.cuenta='$usuario'
                                        and actcomple_evaluaciones.estado=1
                                        group by ac,cre,semestre,docente,promedio,abreviaciones.titulo");
        return view('actividades_complementarias.alumnos.creditos_semestres',compact('historial_creditos'));
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
