<?php

namespace App\Http\Controllers;

use App\ri_estrategia_accion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Session;

class RiEstrategiaAccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request,[
            'desc_accion'=>"required",
            'fecha_programada'=>"required",
            'fecha_final'=>"required",
            'unidad_admin'=>"required",

        ]);

        $accion= array(

            'accion' => mb_strtoupper($request->get('desc_accion'),'utf-8'),
            'fecha' => mb_strtoupper($request->get('fecha_programada'),'utf-8'),
            'fecha_final' => mb_strtoupper($request->get('fecha_final'),'utf-8'),
            'id_unidad_admin' => mb_strtoupper($request->get('unidad_admin'),'utf-8'),

            'id_factor'=> mb_strtoupper($request->get('id_factor_accion'),'utf-8'),

        );
        ri_estrategia_accion::create($accion);
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

        $this->validate($request,[
            'desc_accion_edit'=>"required",
            'fecha_programada_edit'=>"required",
            'fecha_final_edit'=>"required",
            'unidad_admin_edit'=>"required",

        ]);

        $accion= array(

            'accion' => mb_strtoupper($request->get('desc_accion_edit'),'utf-8'),
            'fecha' => mb_strtoupper($request->get('fecha_programada_edit'),'utf-8'),
            'fecha_final' => mb_strtoupper($request->get('fecha_final_edit'),'utf-8'),
            'id_unidad_admin' => mb_strtoupper($request->get('unidad_admin_edit'),'utf-8'),

        );
        ri_estrategia_accion::find($id)->update($accion);
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
        ri_estrategia_accion::destroy($id);
        return back();
    }
    public function addFile(ri_estrategia_accion $id, Request $request)
    {
        if($request->file('evidencia')){
            //dd("holis");
            $path=Storage::disk('public')->put('filesRiesgos',$request->file('evidencia'));
            $id->file=$path;
            $id->status=2;
            $id->save();
            Session::put('msg_ok', 'ok');


        }
        return back();

    }
}
