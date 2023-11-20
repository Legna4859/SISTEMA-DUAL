<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;

class Resi_Registrar_objetivosController extends Controller
{
    public function index(){
        $id_usuario = Session::get('usuario_alumno');
        $periodo = Session::get('periodo_actual');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');

        $sin_objetivos=DB::selectOne('SELECT count(resi_objetivos.id_objetivos) numero from resi_objetivos WHERE resi_objetivos.id_anteproyecto='.$anteproyecto->id_anteproyecto.'');

        $sin_objetivos=$sin_objetivos->numero;
        if($sin_objetivos ==0){
            $objetivo_general=" ";
            $objetivo_especifico=" ";

        }
        if($sin_objetivos ==1){
            $objetivo=DB::selectOne('SELECT  *from resi_objetivos WHERE resi_objetivos.id_anteproyecto='.$anteproyecto->id_anteproyecto.'');
            $objetivo_general=$objetivo->obj_general;
            $objetivo_especifico=$objetivo->obj_especifico;


        }
        $enviado_anteproyecto=DB::selectOne('select resi_anteproyecto.estado_enviado proy from resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $enviado_anteproyecto=$enviado_anteproyecto->proy;
        return view('residencia.partials.objetivos',compact('anteproyecto','sin_objetivos','objetivo_general','objetivo_especifico','enviado_anteproyecto'));
    }
    public function store(Request $request){

        $this->validate($request,[
            'sin_objetivos' => 'required',
            'objetivo_general' => 'required',
            'objetivo_especifico' => 'required',
        ]);

        $sin_objetivos = $request->input("sin_objetivos");
        $objetivo_general = $request->input("objetivo_general");
        $objetivo_especifico = $request->input("objetivo_especifico");
        $id_usuario = Session::get('usuario_alumno');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $periodo = Session::get('periodo_actual');
        $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.id_anteproyecto FROM resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $id_anteproyecto=$anteproyecto->id_anteproyecto;
        if($sin_objetivos== 0) {
            DB:: table('resi_objetivos')->insert(['id_anteproyecto' => $id_anteproyecto, 'obj_general' => $objetivo_general, 'obj_especifico' => $objetivo_especifico]);
        }
        if($sin_objetivos == 1){

            DB::update("UPDATE resi_objetivos SET obj_general ='$objetivo_general', obj_especifico ='$objetivo_especifico'  WHERE resi_objetivos.id_anteproyecto =$id_anteproyecto");
        }
        return back();

    }
}
