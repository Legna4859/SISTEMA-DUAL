<?php

namespace App\Http\Controllers;

use App\ri_requisitos;
use App\ri_riesgo;
use Illuminate\Http\Request;

class RiRequisitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

      //  dd("oki");
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
            'requisito' => 'required',
           // 'riesgo' => 'required',
        ]);

        $parte = array(
            'des_requisito' => mb_strtoupper($request->get('requisito'),'utf-8'),
            'id_uni_p' => mb_strtoupper($request->get('id_uni_p'),'utf-8'),
        );
        ri_requisitos::create($parte);
       // $id_requisito=ri_requisitos::where('des_requisito',$request->get('requisito'))->where('id_uni_p',$request->get('id_uni_p'))->get();
        //$riesgo=array('des_riesgo' => mb_strtoupper($request->get('riesgo'),'utf-8'),
          //  'id_requisito' => mb_strtoupper($id_requisito[0]->id_requisito,'utf-8'),);
        //ri_riesgo::create($riesgo);
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

      //  dd("oki");
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
            'des_dato_modificar' => 'required',

        ]);

        $requisito = array(
            'des_requisito' => mb_strtoupper($request->get('des_dato_modificar'),'utf-8'),

        );

        ri_requisitos::find($id)->update($requisito);
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
        ri_requisitos::destroy($id);
        ri_riesgo::where('id_requisito',$id)->delete();

        return back();
    }
}
