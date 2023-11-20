<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
class Buscar_profesores extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $periodo=Session::get('periodo_actual');

        $profesores=DB::select('select DISTINCT(gnral_personales.nombre),gnral_personales.id_personal 
                                from gnral_personales, gnral_horarios,gnral_horas_profesores,gnral_periodos,gnral_periodo_carreras,gnral_carreras 
                                where gnral_periodos.id_periodo='.$periodo.' 
                                and gnral_periodo_carreras.id_carrera=gnral_carreras.id_carrera 
                                and gnral_periodo_carreras.id_periodo=gnral_periodos.id_periodo 
                                and gnral_horarios.id_personal=gnral_personales.id_personal 
                                and gnral_horarios.id_periodo_carrera=gnral_periodo_carreras.id_periodo_carrera and
                                gnral_horas_profesores.id_horario_profesor=gnral_horarios.id_horario_profesor');


        //$carreras=DB::select('select DISTINCT(carreras.nombre) from carreras, periodo_carrera,periodo WHERE periodo.id_periodo=13 and periodo_carrera.id_carrera=carreras.id_carreras and periodo_carrera.id_periodo=periodo_carrera.id_periodo');
      //  $num=count($carreras);
       // dd($carreras);
        
        return view('evaluacion_docente.Admin.buscar',compact('carreras','profesores'));
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
