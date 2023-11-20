<?php

namespace App\Http\Controllers;

use App\ri_estrategia_riesgo;
use App\ri_valoracion_efecto;
use Illuminate\Http\Request;

class RiValoracionEfectoController extends Controller
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
       // dd("hola");
        if ($request->get('grado_impacto'))
            $valoracion_riesgo = array(
                'id_reg_riesgo' => mb_strtoupper($request->get('id_reg_riesgo_val_efec'), 'utf-8'),
                'efecto' => mb_strtoupper($request->get('descripcion_efecto'), 'utf-8'),
                'grado_impacto' => mb_strtoupper($request->get('grado_impacto'), 'utf-8'),
                'probabilidad' => mb_strtoupper($request->get('probabilidad_ocurrencia'), 'utf-8'),
                'cuadrante' => 0,
            );

        else
            $valoracion_riesgo = array(
                'id_reg_riesgo' => mb_strtoupper($request->get('id_reg_riesgo_val_efec'), 'utf-8'),
                'impacto_final' => mb_strtoupper($request->get('impacto_final'), 'utf-8'),
                'ocurrencia_final' => mb_strtoupper($request->get('ocurrencia_final'), 'utf-8'),
            );
        ri_valoracion_efecto::find($id)->update($valoracion_riesgo);
        if ($request->get('id_estrategia')) {
            $estrategias = array(
                'id_estrategia' => mb_strtoupper($request->get('id_estrategia'), 'utf-8'),
                'id_reg_riesgo' => mb_strtoupper($request->get('id_reg_riesgo_val_efec'), 'utf-8'),
            );
            if ($request->get('id_estrategia_r')){
                $id_estrategia_r = $request->get('id_estrategia_r');
                ri_estrategia_riesgo::find($id_estrategia_r)->update($estrategias);
            }
            else{
                ri_estrategia_riesgo::create($estrategias);
            }
        }
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
    }
}
