<?php

namespace App\Http\Controllers;

use App\ri_proceso;
use App\ri_sistema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class RiProcesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $id_unidad=Session::get('id_unidad_admin');
        $procesos =ri_proceso::join('ri_proceso_unidad','ri_proceso.id_proceso', '=', 'ri_proceso_unidad.id_proceso')
            ->where('ri_proceso_unidad.id_unidad_admin', '=', $id_unidad)
            ->where('ri_proceso.id_sistema',"!=",3)
            ->get();
        $sistemas=ri_sistema::all();
        return view('riesgos.proceso',compact('procesos','sistemas'));
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
        $this->validate($request,[
            'des_proceso' => 'required',
            'id_sistema' => 'required',


        ]);

        $procesos = array(
            'des_proceso' => mb_strtoupper($request->get('des_proceso'),'utf-8'),
            'id_sistema'=>$request->get('id_sistema'),

        );

        ri_proceso::create($procesos);
        return redirect('/riesgos/proceso');
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
        return (ri_proceso::find($id));
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
        //dd($request);
        $this->validate($request,[
            'des_proceso_modi' => 'required',
            'id_sistema_edit' => 'required',



        ]);

        $selec_mod = array(
            'des_proceso' => mb_strtoupper($request->get('des_proceso_modi'),'utf-8'),
            'id_sistema'=>$request->get('id_sistema_edit'),


        );

        ri_proceso::find($id)->update($selec_mod);
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
}
