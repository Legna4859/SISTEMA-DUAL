<?php
namespace App\Http\Controllers;
use DB;
use Session;
use Illuminate\Http\Request;

class Tutorias_ReporteSemestralInsController extends Controller
{
    public function index(){
      $carreras=DB::table('gnral_carreras')
      ->where('nombre','!=','INGLES')
      ->where('nombre','!=','EDUCACIÓN CONTINUA')
      ->where('nombre','!=','DEPARTAMENTO DE ACTIVIDADES CULTURALES Y DEPORTIVAS')
      ->orderBy('id_carrera')
      ->get();
       $dat_carreras = array();
       $periodo_actual=Session::get('periodo_actual');
      foreach($carreras as $carrera){
        $dat['id_carrera']=$carrera->id_carrera;
        $dat['nombre']=$carrera->nombre;
        $observacion = DB::selectOne('SELECT COUNT(id_carrera) contar from rep_institucional where id_periodo = '.$periodo_actual.' AND id_carrera = '.$carrera->id_carrera.'');
        if($observacion->contar == 0){
            $dat['estado']=1;
            $dat['observacion']='';
        }else{
            $observaciones = DB::selectOne('SELECT *from rep_institucional where id_periodo = '.$periodo_actual.' AND id_carrera = '.$carrera->id_carrera.'');
            $dat['estado']=2;
            $dat['observacion']=$observaciones->observaciones;
        }
        array_push($dat_carreras,$dat);
      }
return view('tutorias.coordina_inst.reportecarrerains.reporte_institucional',compact('dat_carreras'));
    }
    public function guardar_observacion_inst(Request $request){
$hoy = date("Y-m-d H:i:s");
$periodo_actual=Session::get('periodo_actual');
DB::table('rep_institucional')
->insert (['id_periodo'=> $periodo_actual,
'id_carrera'=> $request->id_carreras,
"observaciones"=>$request->observacion,
"fecha_registro"=>$hoy]);
return back ();
    }
    public function editar_observacion_carrera($id_carrera){
        $periodo_actual=Session::get('periodo_actual');
        $observaciones = DB::selectOne('SELECT *from rep_institucional where id_periodo = '.$periodo_actual.' AND id_carrera = '.$id_carrera.'');
        return view('tutorias.coordina_inst.reportecarrerains.mood_observacion',compact('observaciones'));
    } 
    public function guardar_mod_observacion_inst(Request $request, $id_repinstitucional){
        $hoy = date("Y-m-d H:i:s");
        DB::table('rep_institucional')
        ->where('id_repinstitucional', $id_repinstitucional)
        ->update ([
        "observaciones"=>$request->observacion_mod,
        "fecha_registro"=>$hoy]);
        return back ();
    }
}
