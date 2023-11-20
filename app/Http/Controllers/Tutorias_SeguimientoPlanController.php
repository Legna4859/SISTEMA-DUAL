<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class Tutorias_SeguimientoPlanController extends Controller
{
    public function alumnos(Request $request)
    {
        $datos=DB::table('gnral_alumnos')
            ->join('exp_asigna_alumnos','exp_asigna_alumnos.id_alumno','=','gnral_alumnos.id_alumno')
            ->join('plan_asigna_evidencias','plan_asigna_evidencias.id_alumno','=','gnral_alumnos.id_alumno')
            ->select(DB::raw('UPPER(gnral_alumnos.nombre) as nombre, UPPER(gnral_alumnos.apaterno) as apaterno, UPPER(gnral_alumnos.amaterno) as amaterno,gnral_alumnos.cuenta,plan_asigna_evidencias.evidencia'))
            ->where('exp_asigna_alumnos.id_asigna_generacion', '=', $request->id_asigna_generacion)
            ->where('gnral_alumnos.id_carrera','=',$request->id_carrera)
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->orderBy('gnral_alumnos.cuenta')
            ->get();
        return $datos;
    }
    public  function grupos()
    {
        $datos=DB::select('select gnral_carreras.id_carrera, gnral_carreras.nombre,exp_generacion.generacion, 
                exp_asigna_generacion.grupo, exp_asigna_generacion.id_asigna_generacion from gnral_jefes_periodos
                JOIN exp_asigna_tutor on exp_asigna_tutor.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo JOIN
                gnral_personales ON gnral_personales.id_personal=exp_asigna_tutor.id_personal JOIN gnral_carreras on
                gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera JOIN exp_asigna_generacion ON 
                exp_asigna_generacion.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion JOIN exp_generacion
                ON exp_generacion.id_generacion=exp_asigna_generacion.id_generacion where 
                gnral_jefes_periodos.id_periodo='.Session::get('periodo_actual').' and 
                exp_asigna_tutor.deleted_at is null and gnral_personales.tipo_usuario='.Session::get('usuario_alumno'));
        return $datos;
    }
    public  function archivos(Request $request)
    {

        $data['va']=DB::select('SELECT plan_asigna_evidencias.id_alumno,plan_asigna_evidencias.evidencia,plan_actividades.desc_actividad 
                                FROM plan_asigna_evidencias,plan_asigna_planeacion_tutor,
                                exp_asigna_generacion,plan_actividades,exp_asigna_tutor,exp_asigna_alumnos,gnral_alumnos
                                WHERE plan_asigna_evidencias.id_asigna_planeacion_tutor=plan_asigna_planeacion_tutor.id_asigna_planeacion_tutor 
                                
                                AND plan_asigna_planeacion_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion 
                                AND exp_asigna_generacion.deleted_at is null 
                                AND plan_asigna_planeacion_tutor.id_plan_actividad=plan_actividades.id_plan_actividad 
                                AND exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                                AND exp_asigna_tutor.deleted_at is null
                                AND exp_asigna_alumnos.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                                AND exp_asigna_alumnos.deleted_at is null
                                AND exp_asigna_alumnos.id_alumno=gnral_alumnos.id_alumno
                                AND plan_asigna_evidencias.id_alumno=gnral_alumnos.id_alumno
                                AND plan_asigna_evidencias.id_alumno=exp_asigna_alumnos.id_alumno
                                  and exp_asigna_generacion.id_asigna_generacion='.$request->id_asigna_generacion.'
                                AND plan_asigna_evidencias.id_alumno='.$request->id);

        return $data;
    }

}
