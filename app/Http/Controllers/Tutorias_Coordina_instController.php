<?php
namespace App\Http\Controllers;
use App\Tutorias_Plan_actividades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tutorias_Plan_asigna_planeacion_actividad;
use App\Http\Requests;

use Session;

class Tutorias_Coordina_instController extends Controller
{
    public function index(Request $request)
    {
        /*Plan_Planeacion::create([
        "id_periodo"=>Session::get('id_periodo'),
        //"id_personal"=>$request->get("id_personal")
        ]);
        $id=DB::select('SELECT @@identity as id');
        //dd($id);*/

        return view('tutorias.coordina_inst.index');
    }
    public function carreras()
    {
        $carreras=DB::table('gnral_carreras')
            ->where('nombre','!=','INGLES')
            ->where('nombre','!=','EDUCACIÓN CONTINUA')
            ->where('nombre','!=','DEPARTAMENTO DE ACTIVIDADES CULTURALES Y DEPORTIVAS')
            ->orderBy('id_carrera')
            ->get();
        return $carreras;
    }
    public function carreras1()
    {
        $carreras=DB::table('gnral_carreras')
            ->where('nombre','!=','INGLES')
            ->where('nombre','!=','EDUCACIÓN CONTINUA')
            ->where('nombre','!=','DEPARTAMENTO DE ACTIVIDADES CULTURALES Y DEPORTIVAS')
            ->orderBy('id_carrera')
            ->get();
        return $carreras;
    }
    public  function actividades(Request $request)
    {
        $periodo_actual=Session::get('periodo_actual');
        $datos=DB::select('SELECT plan_actividades.id_plan_actividad,
                                  DATE_FORMAT(plan_actividades.fi_actividad,"%d-%m-%Y")as fi_acti,
                                  DATE_FORMAT(plan_actividades.ff_actividad,"%d-%m-%Y")as ff_acti,plan_actividades.desc_actividad,
                                  plan_actividades.id_estado
                                  FROM plan_actividades,exp_generacion
                                  WHERE plan_actividades.id_generacion=exp_generacion.id_generacion
                                  AND plan_actividades.deleted_at is null
                                  AND plan_actividades.id_generacion='.$request->id_generacion.'  and plan_actividades.id_periodo = '.$periodo_actual.'');
        return $datos;
    }
    public function agregar(Request $request)
    {
        $periodo_actual=Session::get('periodo_actual');

        $plan = array('desc_actividad' =>$request->desc_actividad,
            'objetivo_actividad' =>$request->objetivo_actividad,
            'fi_actividad'=>$request->fi_actividad,
            'ff_actividad'=>$request->ff_actividad,
            'id_generacion'=>$request->id_generacion,
            'id_estado'=>2,
            'id_periodo'=>$periodo_actual,
            );
        Tutorias_Plan_actividades::create($plan);
    }
    public function veractividades(Request $request)
    {
        $data['va']=DB::select('SELECT plan_actividades.id_plan_actividad,plan_actividades.desc_actividad,
                                plan_actividades.objetivo_actividad, DATE_FORMAT(plan_actividades.fi_actividad,"%d-%m-%Y")as fi_actividad, DATE_FORMAT(plan_actividades.ff_actividad,"%d-%m-%Y")as ff_actividad
                                FROM plan_actividades,plan_asigna_planeacion_actividad,exp_generacion
                                WHERE plan_asigna_planeacion_actividad.id_plan_actividad=plan_actividades.id_plan_actividad
                                AND plan_actividades.id_generacion=exp_generacion.id_generacion
                                AND plan_actividades.deleted_at is null
                                AND plan_asigna_planeacion_actividad.deleted_at is null
                                AND plan_actividades.id_plan_actividad='.$request->id.' ');
        return $data;
    }
    public function vereliminar(Request $request)
    {
        $data['ac']=DB::select('SELECT plan_actividades.id_plan_actividad
                                FROM plan_actividades,exp_generacion
                                WHERE  plan_actividades.id_generacion=exp_generacion.id_generacion
                                AND plan_actividades.deleted_at is null
                                AND plan_actividades.id_plan_actividad='.$request->id.' ');
        return $data;
    }
    public function del(Request $request)
    {
        date_default_timezone_set('America/Mexico_city');
        DB::table('plan_actividades')
            ->where('id_plan_actividad', '=', $request->id_plan_actividad)
            ->update(array('deleted_at'=>date("Y-m-d H:i:s")));


    }
    public function verupdate(Request $request)
    {
        $data['p']=DB::select('SELECT plan_actividades.id_plan_actividad,plan_actividades.desc_actividad,
                                plan_actividades.objetivo_actividad,plan_actividades.fi_actividad, plan_actividades.ff_actividad
                                FROM plan_actividades,exp_generacion
                                WHERE  plan_actividades.id_generacion=exp_generacion.id_generacion
                                AND plan_actividades.deleted_at is null
                                AND plan_actividades.id_plan_actividad='.$request->id.' ');
        return $data;
    }
    public function enviaupd(Request $request)
    {
        DB::table('plan_actividades')
            ->where('id_plan_actividad', '=', $request->id_plan_actividad)
            ->update(array('fi_actividad'=>$request->fi_actividad,
                'ff_actividad'=>$request->ff_actividad,
                'desc_actividad'=>$request->desc_actividad,
                'objetivo_actividad'=>$request->objetivo_actividad));
    }
    public function sugdesa(Request $request)
    {
        $data['corr']=DB::select('SELECT plan_actividades.id_plan_actividad,plan_actividades.desc_actividad,
                                plan_actividades.objetivo_actividad,plan_actividades.fi_actividad, plan_actividades.ff_actividad,plan_actividades.comentario
                                FROM plan_actividades,exp_generacion
                                WHERE  plan_actividades.id_generacion=exp_generacion.id_generacion
                                AND plan_actividades.deleted_at is null
                                AND plan_actividades.id_plan_actividad='.$request->id.' ');
        return $data;
    }
    /*public function store(Request $request)
    {
        $planea = array(
            "fecha_inicio"=>$request->fecha_inicio,
            "fecha_fin" => $request->fecha_fin,
            "desc_actividad" => $request->desc_actividad,
            "objetivo" => $request->objetivo,
            "instrucciones" => $request->instrucciones,
            "id_semestre"=>$request->id_semestre,
            "id_estado"=>$request->id_estado
        );
        Planeacion::create($planea);
        return response()->json();
    }
    public function edit($id)
    {
        $plan = Planeacion::find($id);
        return view('coordina_inst.edit', compact('plan'));
    }
    public function update(Request $request, $id)
    {
        $plan = Planeacion::find($id);
        $plan->fecha_inicio = $request->get('fecha_inicio');
        $plan->fecha_fin = $request->get('fecha_fin');
        $plan->objetivo = $request->get('objetivo');
        $plan->desc_actividad = $request->get('desc_actividad');
        $plan->instrucciones = $request->get('instrucciones');
        $plan->save();
        return redirect()->route('coordina_inst.index');
    }
    public function destroy($id)
    {
        $plan = Planeacion::find($id);
        $plan->delete();
        return redirect()->back();
    }*/
}
