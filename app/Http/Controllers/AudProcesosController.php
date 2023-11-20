<?php

namespace App\Http\Controllers;

use App\gnral_unidad_administrativa;
use App\ri_proceso;
use App\ri_proceso_unidad;
use App\ri_sistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AudProcesosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sistemas=ri_sistema::orderBy('desc_sistema','ASC')->get();
        $procesos=ri_proceso::orderBy('clave','ASC')->orderBy('des_proceso','ASC')->get();
        return view('auditorias.procesos',compact('procesos','sistemas'));
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
        $validator = Validator::make($request->all(), [
            'clave' => 'required',
            'des_proceso' => 'required',
            'id_sistema' => 'required'
        ]);
        if(!$validator->fails())
            ri_proceso::create(array(
                'clave' => $request->get('clave'),
                'des_proceso' => $request->get('des_proceso'),
                'id_sistema' => $request->get('id_sistema')
            ));
        else
            Session::put('errors',$validator->errors());
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $procesos=ri_proceso_unidad::join("gnral_unidad_administrativa","gnral_unidad_administrativa.id_unidad_admin","=","ri_proceso_unidad.id_unidad_admin")
            ->join("ri_proceso","ri_proceso.id_proceso","=","ri_proceso_unidad.id_proceso")
            ->where("ri_proceso_unidad.id_proceso",$id)->get();
        $id=ri_proceso::find($id);
        $unidades=gnral_unidad_administrativa::whereNotIn("id_unidad_admin",$procesos->pluck("id_unidad_admin"))->get();


        return view("auditorias.partials.unidad_proceso",compact("procesos","id","unidades"));
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
        $data=json_decode($id);
        foreach ($data as $datos){
            $sistema = array(
                'id_sistema' => $datos->id_sistema,
            );
            ri_proceso::find($datos->id_proceso)->update($sistema);
        }
        return back();
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
        $validator = Validator::make($request->all(), [
            'clave' => 'required',
            'des_proceso' => 'required',
            'id_sistema' => 'required'
        ]);
        if(!$validator->fails())
            ri_proceso::find($id)->update(array(
                'clave' => $request->get('clave'),
                'des_proceso' => $request->get('des_proceso'),
                'id_sistema' => $request->get('id_sistema')
            ));
        else
            Session::put('errors',$validator->errors());
        return back();
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
        ri_proceso::destroy($id);
        return back();
    }
    public function addUnidad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_admin' => 'required',

        ]);
        if(!$validator->fails())
            ri_proceso_unidad::create(array(
                'id_unidad_admin' => $request->get('id_admin'),
                'id_proceso'=>$request->get("proceso"),

            ));
        return back();

    }
    public function deleteUnidad(ri_proceso_unidad $id)
    {

       $id->delete();
        return back();

    }
}
