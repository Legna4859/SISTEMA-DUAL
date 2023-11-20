<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Tutorias_AsignaCoordinador;
use App\Tutorias_Exp_asigna_coordinador;
use Illuminate\Support\Facades\DB;

use Session;

class Tutorias_AsignaCoordinadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $datosProfesores=Tutorias_AsignaCoordinador::getAllProf();

        $checkasig=DB::select('SELECT exp_asigna_coordinador.id_asigna_coordinador,exp_asigna_coordinador.id_personal,gnral_personales.nombre FROM exp_asigna_coordinador,gnral_personales where exp_asigna_coordinador.id_personal=gnral_personales.id_personal and 
                                   exp_asigna_coordinador.deleted_at is null and
                                  exp_asigna_coordinador.id_jefe_periodo='.Session::get('id_jefe_periodo'));
        if(count($checkasig)>0)
        {
            $datos['check']=true;
        }
        else{
            $datos['check']=false;
        }
        $datos['profesores']=$datosProfesores;
        return $datos;

    }
    public function repo(Request $request){
        dd($request);
        $pdf = PDF::loadView('pdf');
        return $pdf->stream();
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
        Tutorias_Exp_asigna_coordinador::create([
            "id_jefe_periodo"=>Session::get('id_jefe_periodo'),
            "id_personal"=>$request->get("id_personal")
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
        Tutorias_Exp_asigna_coordinador::find($id)->delete();

    }
}
