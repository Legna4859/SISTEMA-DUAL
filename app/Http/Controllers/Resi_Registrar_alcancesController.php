<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
class Resi_Registrar_alcancesController extends Controller
{
    public function index(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');

        $sin_alcances=DB::selectOne('SELECT count(resi_alcances.id_alcances) numero from resi_alcances WHERE resi_alcances.id_anteproyecto='.$anteproyecto->id_anteproyecto.'');

        $sin_alcances=$sin_alcances->numero;
        if($sin_alcances ==0){
            $alcance=" ";
            $limitacion=" ";

        }
        if($sin_alcances ==1){
            $alcances=DB::selectOne('SELECT *from resi_alcances WHERE resi_alcances.id_anteproyecto='.$anteproyecto->id_anteproyecto.'');
            $alcance=$alcances->alcances;
            $limitacion=$alcances->limitaciones;


        }
        $enviado_anteproyecto=DB::selectOne('select resi_anteproyecto.estado_enviado proy from resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $enviado_anteproyecto=$enviado_anteproyecto->proy;
        return view('residencia.partials.alcances',compact('alcance','limitacion','sin_alcances','enviado_anteproyecto'));
    }
    public function  store(Request $request){
        $this->validate($request,[
            'sin_alcances' => 'required',
            'alcance' => 'required',
            'limitacion' => 'required',
        ]);

        $sin_alcances = $request->input("sin_alcances");
        $alcance = $request->input("alcance");
        $limitacion = $request->input("limitacion");
        $id_usuario = Session::get('usuario_alumno');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $periodo = Session::get('periodo_actual');
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $id_anteproyecto=$anteproyecto->id_anteproyecto;
        if($sin_alcances== 0) {
            DB:: table('resi_alcances')->insert(['id_anteproyecto' => $id_anteproyecto, 'alcances' => $alcance, 'limitaciones' => $limitacion]);
        }
        if($sin_alcances == 1){

            DB::update("UPDATE resi_alcances SET alcances = '$alcance', limitaciones = '$limitacion'  WHERE resi_alcances.id_anteproyecto =$id_anteproyecto");
        }
        return back();

    }


}