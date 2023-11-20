<?php

namespace App\Http\Controllers;

use App\ri_factores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiFactoresController extends Controller
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
            'descripcion_factor'=>'required',
            'clasi_factor'=>'required',
            'tipo_factor'=>'required',
            'have_controls'=>'required',
            'id_registro_riesgo'=>'required',
        ]);

        $factor= array(
            'no_factor' => mb_strtoupper('0','utf-8'),
            'id_reg_riesgo' => mb_strtoupper($request->get('id_registro_riesgo'),'utf-8'),
            'descripcion_f' => mb_strtoupper($request->get('descripcion_factor'),'utf-8'),
            'id_cl_f' => mb_strtoupper($request->get('clasi_factor'),'utf-8'),
            'id_tipo_f' => mb_strtoupper($request->get('tipo_factor'),'utf-8'),
            'tiene_controles' => mb_strtoupper($request->get('have_controls'),'utf-8'),
            'no_factor'=>((ri_factores::where('id_reg_riesgo',$request->get('id_registro_riesgo'))->count())+1),

        );

        ri_factores::create($factor);
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
            'descripcion_factor_edit'=>'required',
            'clasi_factor_edit'=>'required',
            'tipo_factor_edit'=>'required',
            'have_controls_edit'=>'required',

        ]);

        $factor= array(
            'descripcion_f' => mb_strtoupper($request->get('descripcion_factor_edit'),'utf-8'),
            'id_cl_f' => mb_strtoupper($request->get('clasi_factor_edit'),'utf-8'),
            'id_tipo_f' => mb_strtoupper($request->get('tipo_factor_edit'),'utf-8'),
            'tiene_controles' => mb_strtoupper($request->get('have_controls_edit'),'utf-8'),

        );
        ri_factores::find($id)->update($factor);
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
      ri_factores::destroy($id);

      return back();
    }
}
