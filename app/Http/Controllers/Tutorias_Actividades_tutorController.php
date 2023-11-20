<?php
namespace App\Http\Controllers;


use App\Tutorias_Plan_actividades;
use App\Tutorias_Plan_asigna_planeacion_actividad;
use App\Tutorias_Plan_asigna_planeacion_tutor;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Session;
class Tutorias_Actividades_tutorController extends Controller
{
    public function index()
    {
        //return view('profesor.actividades');
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        /*$acti = array(
            "id_planeacion"=>$request->id_planeacion,
            "titulo_act" => $request->titulo_act ,
            "desc_act" => $request-> desc_act,
            "instrucciones" => $request->instrucciones,
            "id_estado"=>$request->id_estado
        );
        actividades::create($acti);
        return response()->json();*/
        /*$planea = array(
            "fi_actividad"=>$request->fi_actividad,
            "ff_actividad" => $request->ff_actividad,
            "desc_actividad" => $request->desc_actividad,
            "objetivo_actividad" => $request->objetivo_actividad,
        );
        Plan_actividades::create($planea);
        return response()->json();*/
        $num=DB::select('SELECT exp_asigna_generacion.id_asigna_generacion
        FROM exp_asigna_generacion
        WHERE exp_asigna_generacion.deleted_at is null
        AND exp_asigna_generacion.id_generacion='.$request->id_generacion);

        //dd($num);

        $datos=request()->except('_token');
        Tutorias_Plan_actividades::create($datos);
        $id_actividad=DB::select('SELECT @@identity as id_ac');

        $ic=count($num);
        for ($i = 0; $i <$ic; $i++) {
            Tutorias_Plan_asigna_planeacion_actividad::create([
                "id_asigna_generacion"=>$num[$i]->id_asigna_generacion,
                //"id_actividad "=>$id_actividad[0]->id_ac,
            ]);
            $id=DB::select('SELECT @@identity as id');

            $plan = Tutorias_Plan_asigna_planeacion_actividad::find($id[0]->id);
            $plan->id_plan_actividad = $id_actividad[0]->id_ac;
            $plan->id_estado = $request->id_estado;
            $plan->save();

            Tutorias_Plan_asigna_planeacion_tutor::create([
                "id_asigna_planeacion_actividad"=>$id[0]->id,
                "id_asigna_generacion"=>$num[$i]->id_asigna_generacion,
            ]);
            $idt=DB::select('SELECT @@identity as idt');
            $plan = Tutorias_Plan_asigna_planeacion_tutor::find($idt[0]->idt);
            $plan->id_asigna_planeacion_actividad = $id[0]->id;
            $plan->id_asigna_generacion = $num[$i]->id_asigna_generacion;
            $plan->save();
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $plan = Tutorias_Plan_actividades::find($id);
        $plan->fi_actividad = $request->fi_actividad;
        $plan->ff_actividad = $request->ff_actividad;
        $plan->desc_actividad = $request->desc_actividad;
        $plan->objetivo_actividad = $request->objetivo_actividad;
        $plan->save();
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
    public function update1(Request $request, $id)
    {
        $plan = Tutorias_Plan_asigna_planeacion_actividad::find($id);
        $plan->id_estado = $request->id_estado;
        $plan->save();
        return redirect()->back();
    }
    public function update2(Request $request, $id)
    {
        $plan = Tutorias_Plan_asigna_planeacion_actividad::find($id);
        $plan->comentario = $request->comentario;
        $plan->id_estado = $request->id_estado;
        $plan->save();
        return redirect()->back();
    }


    public function destroy($id)
    {
        $plan = Tutorias_Plan_actividades::find($id);
        $plan->delete();
        return redirect()->back();
    }
}
