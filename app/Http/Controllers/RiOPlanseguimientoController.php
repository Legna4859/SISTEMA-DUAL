<?php

namespace App\Http\Controllers;

use App\ri_o_planseguimiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiOPlanseguimientoController extends Controller
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
            'des_plan_oportunidad' => 'required',
            'fecha_inicial' => 'required',
            'fecha_entrega'=>'required',


        ]);


        $plan_oportunidad= array(
            'des_planseguimiento' => mb_strtoupper($request->get('des_plan_oportunidad'),'utf-8'),
            'fecha_inicial'=>$request->get('fecha_inicial'),
            'fecha'=>$request->get('fecha_entrega'),
            'id_oportunidad'=>$request->get('id_oportunidad_plan'),
        );
        ri_o_planseguimiento::create($plan_oportunidad);
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
        return (ri_o_planseguimiento::find($id));
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
        $this->validate($request,[
            'des_planseguimiento' => 'required',

        ]);

        $factor_mod = array(
            'des_planseguimiento' => mb_strtoupper($request->get('des_planseguimiento'),'utf-8'),
            'fecha_inicial'=>$request->get('f_inicial'),
            'fecha'=>$request->get('f_entrega'),
        );

        var_dump($factor_mod);

        ri_o_planseguimiento::find($id)->update($factor_mod);
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
        ri_o_planseguimiento::destroy($id);
        return back();
    }
}
