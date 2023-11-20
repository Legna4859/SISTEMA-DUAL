<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class Tutorias_ProbabilidadController extends Controller
{
    public function alumnos(Request $request)
    {
        $datos=DB::table('gnral_alumnos')
            ->join('exp_asigna_alumnos','exp_asigna_alumnos.id_alumno','=','gnral_alumnos.id_alumno')
            ->join('prediccion','prediccion.no_cuenta','=','gnral_alumnos.cuenta')
            ->select(DB::raw('UPPER(prediccion.ap) as ap,UPPER(prediccion.am) as am,UPPER(prediccion.nom) as nom,prediccion.no_cuenta,prediccion.no_hijos,
            prediccion.trabaja,prediccion.id_expbebidas,prediccion.materias_repeticion,prediccion.tot_repe,prediccion.materias_especial,prediccion.tot_espe,
            prediccion.gen_espe,prediccion.id_carrera_v,prediccion.sexo_v,prediccion.id_estado_civil_v,prediccion.no_hijos_v,prediccion.no_hermanos_v,
            prediccion.enfermedad_cronica_v,prediccion.trabaja_v,prediccion.practica_deporte_v,prediccion.actividades_culturales_v,
            prediccion.etnia_indigena_v,prediccion.lugar_nacimientos_v,prediccion.nivel_economico_v,prediccion.sostiene_economia_hogar_v,
            prediccion.tegusta_carrera_elegida_v,prediccion.beca_v,prediccion.estado_v,prediccion.id_expbebidas_v,prediccion.poblacion_v,
            prediccion.ant_inst_v,prediccion.satisfaccion_c_v,prediccion.materias_repeticion_v,prediccion.tot_repe_v,prediccion.materias_especial_v,
            prediccion.tot_espe_v,prediccion.gen_espe_v'))
            ->where('exp_asigna_alumnos.id_asigna_generacion', '=', $request->id_asigna_generacion)
            ->where('gnral_alumnos.id_carrera','=',$request->id_carrera)
            ->whereNull('exp_asigna_alumnos.deleted_at')
            ->orderBy('gnral_alumnos.cuenta')
            ->get();
        return $datos;
    }
    public  function grupos()
    {
        //dd(Session::get('id_periodo'));
        $datos=DB::select('select gnral_carreras.id_carrera, gnral_carreras.nombre,exp_generacion.generacion, 
                exp_asigna_generacion.grupo, exp_asigna_generacion.id_asigna_generacion from gnral_jefes_periodos
                JOIN exp_asigna_tutor on exp_asigna_tutor.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo JOIN
                gnral_personales ON gnral_personales.id_personal=exp_asigna_tutor.id_personal JOIN gnral_carreras on
                gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera JOIN exp_asigna_generacion ON 
                exp_asigna_generacion.id_asigna_generacion=exp_asigna_tutor.id_asigna_generacion JOIN exp_generacion
                ON exp_generacion.id_generacion=exp_asigna_generacion.id_generacion where 
                gnral_jefes_periodos.id_periodo='.Session::get('periodo_actual').' and 
                exp_asigna_tutor.deleted_at is null and gnral_personales.tipo_usuario='.Session::get('usuario_alumno').'');

        return $datos;
    }
}

