<?php

namespace App\Http\Controllers;

use App\gnral_unidad_administrativa;
use App\RegRiesgo;
use App\ri_clasif_factor;
use App\ri_estrategia_accion;
use App\ri_estrategia_riesgo;
use App\ri_reg_oportunidad;
use App\ri_tipo_eva;
use App\riEstrategia;
use App\riseleccion;
use App\ritipo_f;
use Illuminate\Http\Request;
use App\Http\Controllers\Process\GetRegistroRiesgo;
use Session;

class RegRiesgoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $detalle_riesgo;
    private $id_unidad_admin;
    function __construct()
    {
       // dd( redirect()->back()->getTargetUrl() );
        $this->middleware('auth');

        $this->id_unidad_admin=Session()->has('id_unidad_admin')?Session()->has('id_unidad_admin'):false;

        if(!$this->id_unidad_admin)
            return back();
        else        $this->id_unidad_admin=session::get('id_unidad_admin');

        $this->detalle_riesgo=new GetRegistroRiesgo();
        $this->estrategia=new RegRiesgo();
    }

    public function index($id_reg_riesgo)
    {


        $unidad_administrativa=gnral_unidad_administrativa::orderBy('nom_departamento')->get();;
        $seleccion_riesgo=riseleccion::all();
        $tipos_factor=ritipo_f::all();
        $clasificaciones_factor=ri_clasif_factor::all();
      //  dd($datos_registro_riesgo);
        $datos_registro_riesgo=$this->detalle_riesgo->getRegRiesgo($id_reg_riesgo, $this->id_unidad_admin);
        $tipos_evas=ri_tipo_eva::all();
        $ri_estrategia=riEstrategia::all();

        return view('riesgos.detalle_riesgo',compact('datos_registro_riesgo','unidad_administrativa','seleccion_riesgo','tipos_factor','clasificaciones_factor','tipos_evas','ri_estrategia'    ));
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

    /**calsifi
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
        Session::put('collapseStatefactor', $id);
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
            'descripcion_riesgo' => 'required',
        ]);

        $riesgo= array('descip_riesgo' => mb_strtoupper($request->get('descripcion_riesgo'),'utf-8'),);
        RegRiesgo::find($id)->update($riesgo);
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
