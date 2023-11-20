<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Session;
class HomeController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adeudo=0;
        $departamento_carrera="";
        $palumno = session()->has('palumno') ? session()->has('palumno') : false;
        if($palumno == true){
            $id_usuario = Session::get('usuario_alumno');
            $id_alu = DB::selectOne('SELECT id_alumno from gnral_alumnos where id_usuario ='.$id_usuario.'');
            $id_alu=$id_alu->id_alumno;

            $adeudo_departamento=DB::selectOne('SELECT COUNT(id_adeudo_departamento)adeudo  
                        FROM adeudo_departamento WHERE id_alumno = '.$id_alu.' ');
            $adeudo_departamento=$adeudo_departamento->adeudo;


            if( $adeudo_departamento ==0){
                $adeudo=0;
                $departamento_carrera="";
            }
            else{
                $adeudo=1;

                $departamento_carrera=array();
                $adeudo_dep=DB::select('SELECT gnral_unidad_administrativa.nom_departamento,
                                adeudo_departamento.comentario FROM adeudo_departamento,
                                gnral_unidad_administrativa WHERE adeudo_departamento.id_alumno = '.$id_alu.' 
                                and gnral_unidad_administrativa.id_unidad_admin=adeudo_departamento.id_departamento ');

                foreach($adeudo_dep as $ade)
                {
                    $nombrea['nombre']= $ade->nom_departamento;
                    $nombrea['comentario']= $ade->comentario;
                    array_push($departamento_carrera, $nombrea);
                }
                $adeudo_informacion=DB::selectOne('SELECT COUNT(id_adeudo_departamento) contar
                                from adeudo_departamento where id_alumno='.$id_alu.' and id_departamento=50');
                if($adeudo_informacion->contar >0)
                {
                    $informacion=DB::select('SELECT  *from adeudo_departamento where id_alumno='.$id_alu.' and id_departamento=50');
                    foreach ($informacion as $info) {
                        $nombre_info['nombre'] = "CENTRO DE INFORMACIÓN";
                        $nombre_info['comentario']=$info->comentario;
                        array_push($departamento_carrera, $nombre_info);
                    }

                }
                $adeudo_bolsa=DB::selectOne('SELECT COUNT(id_adeudo_departamento) contar
                                from adeudo_departamento where id_alumno='.$id_alu.' and id_departamento=100');
                if($adeudo_bolsa->contar >0)
                {
                    $bolsa=DB::select('SELECT  *from adeudo_departamento where id_alumno='.$id_alu.' and id_departamento=100');
                    foreach ($bolsa as $bolsa) {
                        $nombre_bolsa['nombre'] = "BOLSA DE TRABAJO Y SEGUIMIENTO DE EGRESADOS";
                        $nombre_bolsa['comentario']=$bolsa->comentario;
                        array_push($departamento_carrera, $nombre_bolsa);
                    }

                }


            }

            ////encuestas de satisfaccion al cliente
            $periodo=Session::get('periodo_actual');
            //estado encuesta de inscripcion
            $estado_inscripcion= DB::selectOne('SELECT count(id_incripcion) contar from enc_incripcion where id_alumno = '.$id_alu.' and id_periodo = '.$periodo.'  and id_estado = 0');
            $estado_inscripcion=$estado_inscripcion->contar;

            //estado encuesta de rescripcion
            $estado_reinscripcion= DB::selectOne('SELECT count(id_reinscripcion) contar from enc_reinscripcion where id_alumno = '.$id_alu.' and id_periodo = '.$periodo.'  and id_estado = 0');
            $estado_reinscripcion=$estado_reinscripcion->contar;


            if($estado_inscripcion != 0 ){
                $estado_encuesta=1;
                if($estado_inscripcion != 0){
                    $estado_inscripcion=1;
                }

            }else{
                $estado_encuesta=0;
            }



        }else{
            $adeudo=0;
            $departamento_carrera="";
            $estado_encuesta=0;
            $estado_inscripcion=0;
        }

       //dd($departamento_carrera);

        return view('home_recargado', compact('adeudo','departamento_carrera','estado_encuesta', 'estado_inscripcion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
