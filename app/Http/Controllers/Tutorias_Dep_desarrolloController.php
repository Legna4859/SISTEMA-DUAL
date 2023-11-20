<?php
namespace App\Http\Controllers;
use App\Tutorias_Exp_asigna_generacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tutorias_Plan_asigna_planeacion_actividad;
use App\Http\Requests;

use Session;
class Tutorias_Dep_desarrolloController extends Controller
{
    public function index()
    {


        return view('tutorias.dep_desarrollo.index');
    }
    public  function generacion()
    {
        //dd(Session::get('id_periodo'));
        $datos=DB::select('SELECT *from exp_generacion
            GROUP BY exp_generacion.generacion ASC');

        return $datos;
    }
    public function update(Request $request, $id)
    {
        $num=DB::select('SELECT plan_asigna_planeacion_actividad.id_asigna_planeacion_actividad
        FROM plan_asigna_planeacion_actividad,plan_actividades
        WHERE plan_actividades.deleted_at is null
        AND plan_actividades.id_plan_actividad=plan_asigna_planeacion_actividad.id_plan_actividad
        AND plan_asigna_planeacion_actividad.id_plan_actividad='.$id);
        //dd($num);

        $ic=count($num);
        for ($i = 0; $i <$ic; $i++) {
            $plan = Tutorias_Plan_asigna_planeacion_actividad::find($num[$i]->id_asigna_planeacion_actividad);
            $plan->id_estado = $request->id_estado;
            $plan->save();
        }

        return redirect()->back();
    }
    public function ver(Request $request)
    {
        $data['des']=DB::select('SELECT plan_actividades.id_plan_actividad,plan_actividades.desc_actividad,
                                plan_actividades.objetivo_actividad, DATE_FORMAT(plan_actividades.fi_actividad,"%d-%m-%Y")as fi_actividad, DATE_FORMAT(plan_actividades.ff_actividad,"%d-%m-%Y")as ff_actividad
                                FROM plan_actividades,exp_generacion
                                WHERE 
                               plan_actividades.id_generacion=exp_generacion.id_generacion
                                AND plan_actividades.deleted_at is null
                                AND plan_actividades.id_plan_actividad='.$request->id.' ');
        return $data;
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
                                   AND plan_actividades.id_generacion='.$request->id_generacion.' and plan_actividades.id_periodo = '.$periodo_actual.' ');
        return $datos;
    }
    public function verco(Request $request)
    {
        $data['coor_c']=DB::select('SELECT plan_actividades.id_plan_actividad,plan_actividades.desc_actividad, 
                                   plan_actividades.objetivo_actividad,plan_actividades.comentario, 
                                   DATE_FORMAT(plan_actividades.fi_actividad,"%d-%m-%Y")as fi_actividad, 
                                   DATE_FORMAT(plan_actividades.ff_actividad,"%d-%m-%Y")as ff_actividad
                                   FROM plan_actividades,exp_generacion
                                   WHERE  plan_actividades.id_generacion=exp_generacion.id_generacion
                                   AND plan_actividades.deleted_at is null
                                   AND plan_actividades.id_plan_actividad='.$request->id.' ');
        return $data;
    }
    public function aprueba(Request $request)
    {
        DB::table('plan_actividades')
            ->where('id_plan_actividad', '=', $request->id_plan_actividad)
            ->update(array('id_estado'=>1));
    }
    public function sugesend(Request $request)
    {
        DB::table('plan_actividades')
            ->where('id_plan_actividad', '=', $request->id_plan_actividad)
            ->update(array('comentario'=>$request->comentario,
                'id_estado'=>3));
    }
    public function sugesend2(Request $request)
    {
        DB::table('plan_actividades')
            ->where('id_plan_actividad', '=', $request->id_plan_actividad)
            ->update(array('comentario'=>$request->comentario));
    }
    public function corraprob(Request $request)
    {
        DB::table('plan_actividades')
            ->where('id_plan_actividad', '=', $request->id_plan_actividad)
            ->update(array( 'comentario'=>NULL,
                'id_estado'=>1));
    }
}
