<?php

namespace App\Http\Controllers;

use App\ri_estrategia_riesgo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiEstrategiaRiesgoController extends Controller
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
            'id_reg_riesgo' => 'required',
            'id_estrategia' => 'required',
        ]);

        $estrategias = array(
            'id_reg_riesgo' => mb_strtoupper($request->get('id_reg_riesgo'),'utf-8'),
            'id_estrategia' => mb_strtoupper($request->get('id_estrategia'),'utf-8'),
        );
        ri_estrategia_riesgo::create($estrategias);
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
        ri_estrategia_riesgo::destroy($id);
        return back();
    }
}
