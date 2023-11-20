<?php

namespace App\Http\Controllers;

use App\ri_evaluacion_control;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiEvaluacionControlController extends Controller
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
        $this->validate($request,[
            'descripcion_eva_control'=>"required",
            'tipo_eva_control'=>"required",
            'documentado_eva_control'=>"required",
            'formalizado_eva_control'=>"required",
            'aplica_eva_control'=>"required",
            'efectivo_eva_control'=>"required",
        ]);

        $eva_control= array(
            'id_factor'=>mb_strtoupper($request->get('id_factor_eva'),'utf-8'),
            'descripcion' => mb_strtoupper($request->get('descripcion_eva_control'),'utf-8'),
            'id_tipo_eva' => mb_strtoupper($request->get('tipo_eva_control'),'utf-8'),
            'documentado' => mb_strtoupper($request->get('documentado_eva_control'),'utf-8'),
            'formalizado' => mb_strtoupper($request->get('formalizado_eva_control'),'utf-8'),
            'aplica' => mb_strtoupper($request->get('aplica_eva_control'),'utf-8'),
            'efectivo' => mb_strtoupper($request->get('efectivo_eva_control'),'utf-8'),

            'No_controles_eva'=>((ri_evaluacion_control::where('id_factor',$request->get('id_factor_eva'))->count())+1),
        );


            if($eva_control['documentado']=="NO" || $eva_control['formalizado']=="NO" || $eva_control['aplica']=="NO" || $eva_control['efectivo']=="NO")
            {
                $eva_control['resultado']='DEFICIENTE';
            }
            else{
                $eva_control['resultado']='SUFICIENTE';
            }

        ri_evaluacion_control::create($eva_control);
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
            'descripcion_eva_control_edit'=>"required",
            'tipo_eva_control_edit'=>"required",
            'documentado_eva_control_edit'=>"required",
            'formalizado_eva_control_edit'=>"required",
            'aplica_eva_control_edit'=>"required",
            'efectivo_eva_control_edit'=>"required",
        ]);

        $eva_control= array(

            'descripcion' => mb_strtoupper($request->get('descripcion_eva_control_edit'),'utf-8'),
            'id_tipo_eva' => mb_strtoupper($request->get('tipo_eva_control_edit'),'utf-8'),
            'documentado' => mb_strtoupper($request->get('documentado_eva_control_edit'),'utf-8'),
            'formalizado' => mb_strtoupper($request->get('formalizado_eva_control_edit'),'utf-8'),
            'aplica' => mb_strtoupper($request->get('aplica_eva_control_edit'),'utf-8'),
            'efectivo' => mb_strtoupper($request->get('efectivo_eva_control_edit'),'utf-8'),

        );
        if($eva_control['documentado']=="NO" || $eva_control['formalizado']=="NO" || $eva_control['aplica']=="NO" || $eva_control['efectivo']=="NO")
        {
            $eva_control['resultado']='DEFICIENTE';
        }
        else{
            $eva_control['resultado']='SUFICIENTE';
        }
        ri_evaluacion_control::find($id)->update($eva_control);
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
        ri_evaluacion_control::destroy($id);
        return back();
    }
}
