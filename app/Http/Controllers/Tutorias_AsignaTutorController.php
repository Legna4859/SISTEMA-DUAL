<?php

namespace App\Http\Controllers;

use App\Tutorias_Exp_asigna_tutor;
use Illuminate\Http\Request;
use App\Tutorias_AsignaCoordinador;

use Session;
use Illuminate\Support\Facades\DB;


class Tutorias_AsignaTutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $datosProf=Tutorias_AsignaCoordinador::getAllProf();
        $noGrupo=DB::select('SELECT exp_asigna_generacion.id_asigna_generacion,exp_generacion.generacion,exp_generacion.id_generacion, exp_asigna_generacion.grupo
                                from exp_generacion, exp_asigna_generacion WHERE exp_generacion.id_generacion=exp_asigna_generacion.id_generacion
                              AND exp_asigna_generacion.id_asigna_generacion NOT IN (SELECT exp_asigna_generacion.id_asigna_generacion
                              from gnral_personales, exp_asigna_tutor,exp_asigna_generacion,exp_generacion where
                               exp_asigna_tutor.id_personal=gnral_personales.id_personal AND exp_asigna_tutor.id_asigna_generacion=exp_asigna_generacion.id_asigna_generacion AND 
                               exp_asigna_generacion.id_generacion=exp_generacion.id_generacion and exp_asigna_tutor.deleted_at is null AND exp_asigna_tutor.id_jefe_periodo='.Session::get('id_jefe_periodo').') 
                               and exp_asigna_generacion.deleted_at is null 
                               and exp_asigna_generacion.id_jefe_periodo='.Session::get('id_jefe_periodo').' ORDER BY exp_generacion.generacion');

        $datos['profesores']=$datosProf;
        if($noGrupo==null)
        {
            $datos['grupos']=null;
        }
        else{
            $datos['grupos']=$noGrupo;
        }
        return $datos;
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

        Tutorias_Exp_asigna_tutor::create([
            "id_jefe_periodo"=>Session::get('id_jefe_periodo'),
            "id_personal"=>$request->get("id_personal"),
            "id_asigna_generacion"=>$request->get("id_asigna_generacion"),
        ]);
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

        Tutorias_Exp_asigna_tutor::find($id)->delete();
    }
}
