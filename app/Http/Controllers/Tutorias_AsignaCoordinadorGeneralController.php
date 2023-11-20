<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Personal;
use App\Http\Requests;
use App\Tutorias_Desarrollo_asigna_coordinador_general;
use Session;

use Illuminate\Support\Facades\Auth;
use App\User;

class Tutorias_AsignaCoordinadorGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
         $datosProfesores=Personal::getAllProf();
        $datos=$datosProfesores;
        return $datos;

       /* $checkasig=DB::select('SELECT * FROM desarrollo_asigna_coordinador_general,gnral_personales
                                        WHERE desarrollo_asigna_coordinador_general.id_personal=gnral_personales.id_personal
                                        AND desarrollo_asigna_coordinador_general.deleted_at is null
                                        AND desarrollo_asigna_coordinador_general.id_personal_asigna='.Session::get('desarrollo'));
        if(count($checkasig)>0)
        {
            $datos['check']=true;
        }
        else{
            $datos['check']=false;
        }
        $datos['profesores']=$datosProfesores;
        return $datos;*/

    }
    public  function check()
    {
        //dd(Session::get('id_periodo'));
        $checkasig=DB::select('SELECT * FROM desarrollo_asigna_coordinador_general,gnral_personales
                                        WHERE desarrollo_asigna_coordinador_general.id_personal=gnral_personales.id_personal
                                        AND desarrollo_asigna_coordinador_general.deleted_at is null
                                        AND desarrollo_asigna_coordinador_general.id_personal_asigna='.Session::get('desarrollo'));
        if(count($checkasig)>0)
        {
            $datos['check']=true;
        }
        else{
            $datos['check']=false;
        }

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
        Tutorias_Desarrollo_asigna_coordinador_general::create([
            "id_personal_asigna"=>Session::get('desarrollo'),
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

        Tutorias_Desarrollo_asigna_coordinador_general::find($id)->delete();

    }
}
