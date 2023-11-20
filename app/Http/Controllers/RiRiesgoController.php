<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ri_riesgo;
use Session;
class RiRiesgoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $riesgos = DB::table('ri_riesgo')
            ->orderBy('des_riesgo', 'asc')
            ->get();
        //return($riesgos);
        return view('riesgos.riesgos',compact('riesgos'));
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
            'riesgo' => 'required',

        ]);

        $riesgo = array(
            'des_riesgo' => mb_strtoupper($request->get('riesgo'),'utf-8'),
            'id_requisito'=>$request->get('id_requisito_riesgo'),
            'id_unidad_admin'=>Session::get('id_unidad_admin'),
        );

        ri_riesgo::create($riesgo);
        return back();
       // return redirect('/riesgos/riesgo');
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
        //return (ri_riesgo::find($id));
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
   // dd("edit riesgo");
        $this->validate($request,[
            'des_dato_modificar' => 'required',

        ]);

        $riesgo = array(
            'des_riesgo' => mb_strtoupper($request->get('des_dato_modificar'),'utf-8'),

        );

        ri_riesgo::find($id)->update($riesgo);
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
        ri_riesgo::destroy($id);
        return back();
    }
}
