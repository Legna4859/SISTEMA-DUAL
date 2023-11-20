<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Resi_Periodo_eval_anteproyecto;
use App\Http\Requests;
use Session;

class Resi_Periodo_eval_anteproyectoController extends Controller
{
    public function index(){

        $periodo_anteproyectos=DB::select('SELECT resi_periodo_eval_anteproyecto.*,
       gnral_periodos.periodo FROM resi_periodo_eval_anteproyecto,gnral_periodos
WHERE resi_periodo_eval_anteproyecto.id_periodo = gnral_periodos.id_periodo
ORDER BY resi_periodo_eval_anteproyecto.fecha_inicio DESC ');
        $periodo_activo=DB::selectOne('SELECT resi_periodo_eval_anteproyecto.*,
       gnral_periodos.periodo FROM resi_periodo_eval_anteproyecto,gnral_periodos
WHERE resi_periodo_eval_anteproyecto.id_periodo = gnral_periodos.id_periodo and  resi_periodo_eval_anteproyecto.estado_periodo=1');



        return view('residencia.periodo_evaluacion_anteproyecto',compact('periodo_anteproyectos','periodo_activo'));

    }
    public function  store(Request $request){
        $this->validate($request,[
            'fecha_inicial' => 'required',
            'fecha_final' => 'required',
        ]);
        $fecha_inicial=$request->input('fecha_inicial');
        $fecha_final=$request->input('fecha_final');
        $fecha_inicial1=date("Y-m-d ",strtotime($fecha_inicial));
        $fecha_final1=date("Y-m-d ",strtotime($fecha_final));
        $id_periodo = Session::get('periodotrabaja');
        $periodos_evaluacion = array(
            'id_periodo' => $id_periodo,
            'fecha_inicio' =>$fecha_inicial1,
            'fecha_final' => $fecha_final1,

        );
        $agrega_periodoanteproyecto=Resi_Periodo_eval_anteproyecto::create($periodos_evaluacion);
        return back();

    }
    public function eliminar($id_periodos_evaluacion){
        DB::delete('DELETE FROM resi_periodo_eval_anteproyecto WHERE id_periodo_eval_anteproyecto ='.$id_periodos_evaluacion.'');
        return back();
    }
    public function activar_periodo_anteproyecto(Request $request){
        $this->validate($request,[
            'id_periodo_eval_anteproyecto' => 'required',

        ]);
        $id_periodo_eval_anteproyecto=$request->input('id_periodo_eval_anteproyecto');
        DB::table('resi_periodo_eval_anteproyecto')
            ->where('id_periodo_eval_anteproyecto', $id_periodo_eval_anteproyecto)
            ->update(['estado_periodo' => 1,
            ]);
        return back();
    }
    public function desactivar_periodo_anteproyecto(Request $request){
        $this->validate($request,[
            'id_periodo_eval_anteproyecto1' => 'required',

        ]);
        $id_periodo_eval_anteproyecto=$request->input('id_periodo_eval_anteproyecto1');
        DB::table('resi_periodo_eval_anteproyecto')
            ->where('id_periodo_eval_anteproyecto', $id_periodo_eval_anteproyecto)
            ->update(['estado_periodo' => 0,
            ]);
        return back();
    }

}
