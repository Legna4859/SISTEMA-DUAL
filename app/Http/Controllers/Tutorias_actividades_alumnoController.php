<?php
namespace App\Http\Controllers;
use App\Alumnos;
use App\Tutorias_Plan_actividades;
use App\Tutorias_Plan_asigna_evidencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class Tutorias_actividades_alumnoController extends Controller
{
    public function index()
    {
        $periodo_actual=Session::get('periodo_actual');



        $id=Auth::user()->id;
        $datos_alumno=DB::selectOne('SELECT exp_asigna_alumnos.* from exp_asigna_alumnos,exp_asigna_generacion,gnral_jefes_periodos,gnral_alumnos
        where exp_asigna_alumnos.id_asigna_generacion =exp_asigna_generacion.id_asigna_generacion and
        exp_asigna_generacion.id_jefe_periodo = gnral_jefes_periodos.id_jefe_periodo and gnral_jefes_periodos.id_periodo = '.$periodo_actual.' 
        and exp_asigna_alumnos.id_alumno = gnral_alumnos.id_alumno and gnral_alumnos.id_usuario ='.$id.'');

        //DB::enableQueryLog();
        $datos=Tutorias_Plan_actividades::join('plan_asigna_planeacion_tutor','plan_asigna_planeacion_tutor.id_plan_actividad','=','plan_actividades.id_plan_actividad')

            ->join('exp_asigna_generacion','exp_asigna_generacion.id_generacion','=','plan_actividades.id_generacion')
            ->join('exp_asigna_alumnos','exp_asigna_alumnos.id_asigna_generacion','=','exp_asigna_generacion.id_asigna_generacion')


            ->join('exp_asigna_tutor', function ($join){
                $join->on('exp_asigna_tutor.id_asigna_generacion','=','plan_asigna_planeacion_tutor.id_asigna_generacion');
                //->where('exp_asigna_tutor.id_asigna_generacion','=','exp_asigna_generacion.id_asigna_generacion');
            })
            //id alumno
            ->join('gnral_alumnos','exp_asigna_alumnos.id_alumno' , '=',  'gnral_alumnos.id_alumno')
            ->join('users','gnral_alumnos.id_usuario', '=', 'users.id')
            ->where('users.id','=',$id)

            ->whereRaw("exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion")

            ->where('plan_asigna_planeacion_tutor.id_estrategia','=', 1)
            ->where('exp_asigna_alumnos.id_asigna_generacion','=', $datos_alumno->id_asigna_generacion)
            ->whereNull ('exp_asigna_alumnos.deleted_at')
            ->whereNull('exp_asigna_tutor.deleted_at')

            ->select('plan_actividades.desc_actividad', 'plan_actividades.objetivo_actividad',
                'plan_actividades.fi_actividad', 'plan_actividades.ff_actividad','plan_asigna_planeacion_tutor.estrategia','plan_asigna_planeacion_tutor.requiere_evidencia',
                'plan_asigna_planeacion_tutor.id_asigna_planeacion_tutor','exp_asigna_tutor.id_asigna_generacion','exp_asigna_generacion.id_asigna_generacion as id_asigna_generacion2')
            ->get();


        $datos->map(function($value)use ($id){
            //dd($value);
            return $value["evidencia"]=Tutorias_Plan_asigna_evidencias::join('gnral_alumnos','plan_asigna_evidencias.id_alumno' , '=',  'gnral_alumnos.id_alumno')
                ->join('users','gnral_alumnos.id_usuario', '=', 'users.id')
                ->where('users.id','=',$id)
                ->where('plan_asigna_evidencias.id_asigna_planeacion_tutor',$value->id_asigna_planeacion_tutor)
                ->select('plan_asigna_evidencias.id_evidencia', 'plan_asigna_evidencias.evidencia')
                ->get();
        });


        return view('tutorias.actividades_alumno.actividades_alumno',compact("datos"));
    }

    public function store(Request $request)
    {

        $id=DB::select('SELECT id_alumno FROM gnral_alumnos WHERE id_usuario='.Auth::user()->id);

        //$plan = Plan_asigna_evidencias::find($id);
        $file=$request->file('evidencia');

        //dd($request->id_asigna_planeacion_tutor);
        $name=time().".".$file->getClientOriginalExtension();
        $file->move(public_path().'/pdf/',$name);

        if($request->id_evidencia==null){
            Tutorias_Plan_asigna_evidencias::create([
                "evidencia" => $name,
                "id_alumno" => $id[0]->id_alumno,
                "id_asigna_planeacion_tutor"=>$request->id_asigna_planeacion_tutor,
            ]);
        }
        else{
            Tutorias_Plan_asigna_evidencias::find($request->id_evidencia)->update(["evidencia"=>$name]);
        }

        return back();
    }
    public function updateExp(Request $request)
    {
        //            ""=>




    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function cerrar()
    {
        //
        Session::flush();
    }

    public function update(Request $request, $id)
    {
        $plan = Tutorias_Plan_asigna_evidencias::find($id);
        if($request->hasFile('evidencia'))
        {
            $file=$request->file('evidencia');
            $name=time().".".$file->getClientOriginalExtension();
            $plan->evidencia = $name;
            $file->move(public_path().'/pdf/',$name);
        }else {
                $file=$request->file('evidencia');
          //  dd($file);
                $name=time()."daat";
                $file->move(public_path().'/pdf/',$name);
        }
        //$plan->evidencia = $request->evidencia;;
        $plan->save();
        return redirect()->back();
    }
    public function destroy($id)
    {
        //
    }
}
