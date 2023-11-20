<?php
namespace App\Http\Controllers;
use App\Tutorias_Asigna_planeacion;
use App\Tutorias_AsignaTutor;
use App\User;
use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class Tutorias_Coordina_carrController extends Controller
{
    public function index()
    {
        $carreras=DB::select('select gnral_carreras.nombre,gnral_carreras.id_carrera from exp_asigna_coordinador
            JOIN gnral_personales ON exp_asigna_coordinador.id_personal=gnral_personales.id_personal 
            JOIN gnral_jefes_periodos ON exp_asigna_coordinador.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo 
            JOIN gnral_carreras ON gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera WHERE exp_asigna_coordinador.id_jefe_periodo 
            IN (SELECT gnral_jefes_periodos.id_jefe_periodo from gnral_jefes_periodos where gnral_jefes_periodos.id_periodo='.Session::get('periodo_actual').') AND 
            exp_asigna_coordinador.deleted_at is null ORDER BY gnral_carreras.nombre ');
        $datos=DB::select('SELECT gnral_carreras.id_carrera,gnral_carreras.nombre as carrera,exp_generacion.generacion,
                            exp_asigna_generacion.grupo,plan_actividades.*,plan_asigna_planeacion_tutor.*,gnral_personales.nombre
                            FROM gnral_carreras,gnral_jefes_periodos,exp_asigna_coordinador,exp_generacion,
                            exp_asigna_generacion,gnral_periodos,plan_planeacion,plan_asigna_planeacion_actividad,plan_actividades,plan_asigna_planeacion_tutor,exp_asigna_tutor,gnral_personales
                            WHERE gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera
                            AND gnral_jefes_periodos.id_jefe_periodo=exp_asigna_coordinador.id_jefe_periodo
                            AND exp_asigna_coordinador.deleted_at is null
                            AND gnral_periodos.id_periodo=exp_asigna_generacion.id_generacion
                            AND exp_asigna_generacion.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo
                            AND exp_asigna_generacion.deleted_at is null
                            AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                            AND plan_planeacion.id_generacion=exp_asigna_generacion.id_generacion
                            AND plan_planeacion.id_planeacion=plan_asigna_planeacion_actividad.id_planeacion
                            AND plan_asigna_planeacion_actividad.id_plan_actividad=plan_actividades.id_plan_actividad
                            AND plan_actividades.deleted_at is null
                            AND plan_asigna_planeacion_tutor.id_asigna_planeacion_actividad=plan_asigna_planeacion_actividad.id_asigna_planeacion_actividad
                            AND plan_asigna_planeacion_tutor.id_asigna_tutor=exp_asigna_tutor.id_asigna_tutor
                            AND exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                            AND exp_asigna_tutor.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo
                            AND plan_asigna_planeacion_tutor.id_sugerencia=2
                            AND exp_asigna_coordinador.id_personal=gnral_personales.id_personal
                            AND gnral_personales.tipo_usuario='.Auth::user()->id.'
                            AND exp_asigna_tutor.id_asigna_tutor=plan_asigna_planeacion_tutor.id_asigna_tutor');

        //dd(Auth::user()->id);
        return view('tutorias.coordina_carrera.index',compact('carreras','datos'));
    }
    public function store(Request $request)
    {
        $asigna = array(
            "id_planeacion" => $request->id_planeacion,
            "id_asigna_tutor" => $request->id_asigna_tutor,
        );
        Tutorias_Asigna_planeacion::create($asigna);
        return response()->json();
    }
    public function destroy($id)
    {
        $planea = Tutorias_Asigna_planeacion::find($id);
        $planea->delete();
        return redirect()->back();
    }

    public function generaciones()
    {

        $generaciones=DB::select('SELECT gnral_carreras.id_carrera,gnral_carreras.nombre,exp_generacion.generacion,
                            exp_asigna_generacion.grupo,plan_actividades.*,plan_asigna_planeacion_tutor.*,gnral_personales.nombre
                            FROM gnral_carreras,gnral_jefes_periodos,exp_asigna_coordinador,exp_generacion,
                            exp_asigna_generacion,gnral_periodos,plan_planeacion,plan_asigna_planeacion_actividad,plan_actividades,plan_asigna_planeacion_tutor,exp_asigna_tutor,gnral_personales
                            WHERE gnral_carreras.id_carrera=gnral_jefes_periodos.id_carrera
                            AND gnral_jefes_periodos.id_jefe_periodo=exp_asigna_coordinador.id_jefe_periodo
                            AND exp_asigna_coordinador.deleted_at is null
                            AND gnral_periodos.id_periodo=exp_asigna_generacion.id_generacion
                            AND exp_asigna_generacion.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo
                            AND exp_asigna_generacion.deleted_at is null
                            AND exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                            AND plan_planeacion.id_generacion=exp_asigna_generacion.id_generacion
                            AND plan_planeacion.id_planeacion=plan_asigna_planeacion_actividad.id_planeacion
                            AND plan_asigna_planeacion_actividad.id_plan_actividad=plan_actividades.id_plan_actividad
                            AND plan_actividades.deleted_at is null
                            AND plan_asigna_planeacion_tutor.id_asigna_planeacion_actividad=plan_asigna_planeacion_actividad.id_asigna_planeacion_actividad
                            AND plan_asigna_planeacion_tutor.id_asigna_tutor=exp_asigna_tutor.id_asigna_tutor
                            AND exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion
                            AND exp_asigna_tutor.id_jefe_periodo=gnral_jefes_periodos.id_jefe_periodo
                            AND plan_asigna_planeacion_tutor.id_sugerencia=2
                            AND exp_asigna_coordinador.id_personal=gnral_personales.id_personal
                            AND gnral_personales.tipo_usuario='.Auth::user()->id.'
                            AND exp_asigna_tutor.id_asigna_tutor=plan_asigna_planeacion_tutor.id_asigna_tutor');
        return $generaciones;
    }
}
