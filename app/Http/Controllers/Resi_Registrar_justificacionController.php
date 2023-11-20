<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
class Resi_Registrar_justificacionController extends Controller
{
    public function index(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');

        $sin_justificacion=DB::selectOne('SELECT count(resi_justificacion.id_justificacion) numero from resi_justificacion WHERE resi_justificacion.id_anteproyecto='.$anteproyecto->id_anteproyecto.'');

        $sin_justificacion=$sin_justificacion->numero;
        if($sin_justificacion ==0){
            $justificacion=" ";


        }
        if($sin_justificacion ==1){
            $justif=DB::selectOne('SELECT *from resi_justificacion WHERE resi_justificacion.id_anteproyecto='.$anteproyecto->id_anteproyecto.'');
            $justificacion=$justif->justificacion;



        }
        $enviado_anteproyecto=DB::selectOne('select resi_anteproyecto.estado_enviado proy from resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $enviado_anteproyecto=$enviado_anteproyecto->proy;
        return view('residencia.partials.justificacion',compact('sin_justificacion','justificacion','enviado_anteproyecto'));
    }
    public function store(Request $request){

        $this->validate($request,[
            'sin_justificacion' => 'required',
            'justificacion' => 'required',
        ]);

        $sin_justificacion = $request->input("sin_justificacion");
        $justificacion = $request->input("justificacion");
        $id_usuario = Session::get('usuario_alumno');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $periodo = Session::get('periodo_actual');
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $id_anteproyecto=$anteproyecto->id_anteproyecto;
        if($sin_justificacion== 0) {
            DB:: table('resi_justificacion')->insert(['id_anteproyecto' => $id_anteproyecto, 'justificacion' => $justificacion]);
        }
        if($sin_justificacion == 1){

            DB::update("UPDATE resi_justificacion SET justificacion = '$justificacion' WHERE resi_justificacion.id_anteproyecto=$id_anteproyecto");
        }
        return back();
    }
}
