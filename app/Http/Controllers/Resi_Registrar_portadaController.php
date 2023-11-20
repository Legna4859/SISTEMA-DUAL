<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;

class Resi_Registrar_portadaController extends Controller
{
    public function index(){
        $periodo = Session::get('periodo_actual');
        $tipo_proyecto=DB::select('SELECT * FROM resi_tipo_proyecto where id_tipo_proyecto=2');
        $id_usuario = Session::get('usuario_alumno');
        $datosalumno=DB::selectOne('select * FROM gnral_alumnos WHERE id_usuario='.$id_usuario.'');
        $alumno=$datosalumno->id_alumno;
        $nombres=DB::selectOne('SELECT gnral_alumnos.nombre,gnral_alumnos.apaterno,gnral_alumnos.amaterno FROM gnral_alumnos WHERE id_alumno ='.$alumno.'');
        $sinant=DB::selectOne('SELECT count(resi_anteproyecto.id_anteproyecto) numero from resi_anteproyecto 
        where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');

        if($sinant->numero==0){
            $sin_proyecto=0;
            $id_proyecto=0;
            $nombre="";
        }
        if ($sinant->numero == 1){
            $anteproyecto=DB::selectOne('SELECT resi_anteproyecto.*,resi_proyecto.nom_proyecto,resi_proyecto.id_tipo_proyecto FROM resi_anteproyecto,resi_proyecto 
WHERE resi_proyecto.id_proyecto=resi_anteproyecto.id_proyecto and resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
            $sin_proyecto=1;
            $id_proyecto=$anteproyecto->id_proyecto;
            $nombre=$anteproyecto->nom_proyecto;

        }

        $registro_proy=DB::selectOne('select count(resi_anteproyecto.id_anteproyecto) proy from resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        $registro_proy=$registro_proy->proy;
        $enviado_anteproyecto=DB::selectOne('select resi_anteproyecto.estado_enviado proy from resi_anteproyecto where resi_anteproyecto.id_alumno='.$alumno.' and resi_anteproyecto.id_periodo='.$periodo.'');
        //$enviado_anteproyecto=$enviado_anteproyecto->proy;
        if($enviado_anteproyecto == null)
        {
            $enviado_anteproyecto=0;
        }
        else{
            $enviado_anteproyecto=$enviado_anteproyecto->proy;
        }
        return view('residencia.partials.portada',compact('tipo_proyecto','sin_proyecto','anteproyecto','id_proyecto','nombres','nombre','registro_proy','enviado_anteproyecto'));
    }
    public function store(Request $request)
    {

        $this->validate($request,[
            'tipo_proy' => 'required',
            'nombre_proyecto' => 'required',
            'sin_proyecto' => 'required',
        ]);
        $sin_proyecto = $request->input("sin_proyecto");
        $id_tipo_proyecto = $request->input("tipo_proy");
        $nombre_proyecto = $request->input("nombre_proyecto");
        $nombre_proyecto= mb_strtoupper($nombre_proyecto, 'utf-8') ;
        $id_usuario = Session::get('usuario_alumno');
        $datosalumno = DB::selectOne('select * FROM `gnral_alumnos` WHERE id_usuario=' . $id_usuario . '');
        $alumno = $datosalumno->id_alumno;
        if($sin_proyecto == 0) {
            $numero = DB::selectOne('SELECT MAX(resi_proyecto.id_proyecto) numero FROM resi_proyecto');
            $numero = $numero->numero;
            $num = isset($numero);
            if ($num == false) {
                $numeross = 1;
            }

            if ($num == true) {
                $numeross = $numero + 1;

            }

            $periodo = Session::get('periodo_actual');
            $fecha = date("Y-m-d");
            DB:: table('resi_proyecto')->insert(['id_proyecto' => $numeross, 'nom_proyecto' => $nombre_proyecto, 'id_tipo_proyecto' => $id_tipo_proyecto
            ]);
            DB:: table('resi_anteproyecto')->insert(['id_alumno' => $alumno, 'id_periodo' => $periodo, 'id_proyecto' => $numeross, 'fecha' => $fecha]);
        }
        $periodo = Session::get('periodo_actual');
        if($sin_proyecto == 1){
            $alumno=DB::selectOne('SELECT * FROM resi_anteproyecto WHERE id_alumno ='.$alumno.' and id_periodo='.$periodo.'' );
            DB::update("UPDATE resi_proyecto SET nom_proyecto ='$nombre_proyecto'  WHERE resi_proyecto.id_proyecto =$alumno->id_proyecto");
        }
        return back();
    }






}

