<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\gnral_unidad_administrativa;
use App\RegRiesgo;
use App\riseleccion;
use Illuminate\Http\Request;


class RegRiesgoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $riesgos = RegRiesgo::with('riesgos','unidadAdmin','seleccion','nivelDecision','clasificacionRiesgo')->get();

        $unidad_administrativa=gnral_unidad_administrativa::all();
        $seleccion_riesgo=riseleccion::all();
       // dd($riesgos);

        return response()->json($riesgos);

        //   return view('riesgos.registro_riesgos',compact('riesgos','unidad_administrativa','seleccion_riesgo'));
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

        $this->validate($request, [
            'unidad_administrativa' => 'required',
            'seleccion_riesgo' => 'required',
            'descripcion_riesgo' => 'required',


        ]);

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
        return view("riesgos.index");
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
    }
}
