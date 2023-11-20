<?php

namespace App\Http\Controllers;

use App\ri_estrategia_accion;
use App\ri_o_calificacion;
use App\ri_o_mejoracliente;
use App\ri_o_mejorareputacion;
use App\ri_o_mejorasgc;
use App\ri_o_ocurrenciasp;
use App\ri_o_planseguimiento;
use App\ri_o_potencialapertura;
use App\ri_o_potencialcosto;
use App\ri_o_potencialcrecimiento;
use App\ri_o_probabilidad;
use App\ri_reg_oportunidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Session;

class RiRegOportunidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    function __construct()
    {
        $this->middleware('auth');


    }
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
            'oportunidad' => 'required',

        ]);

        $oportunidad = array(
            'des_oportunidad' => mb_strtoupper($request->get('oportunidad'),'utf-8'),
            'id_requisito'=>$request->get('id_requisito_oportunidad'),
            'id_unidad_admin'=>Session::get('id_unidad_admin'),
        );

        ri_reg_oportunidad::create($oportunidad);
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
        $probabilidades=ri_o_probabilidad::all();
        $ocurrenciaps=ri_o_ocurrenciasp::all();
        $potencialaperturas=ri_o_potencialapertura::all();
        $potencialcrecimientos=ri_o_potencialcrecimiento::all();
        $mejoraclientes=ri_o_mejoracliente::all();
        $mejorasgcs=ri_o_mejorasgc::all();
        $mejorareputacions=ri_o_mejorareputacion::all();
        $potencialcostos=ri_o_potencialcosto::all();
        $umbral=ri_o_calificacion::all();
        $oportunidades=ri_reg_oportunidad::where('id_oportunidad',$id)->get();
        //dd($oportunidades);

        return view("riesgos.detalle_oportunidad",compact('oportunidades','ocurrenciaps','probabilidades','potencialaperturas','potencialcrecimientos','mejoraclientes','mejorasgcs','mejorareputacions','potencialcostos','umbral'));
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
        //dd($request->all());
        if($request->has("des_dato_modificar"))
        {
            $this->validate($request,[
                'des_dato_modificar' => 'required',

            ]);

            $oportunidad = array(
                'des_oportunidad' => mb_strtoupper($request->get('des_dato_modificar'),'utf-8'),

            );
        }else
        {
            $this->validate($request,[
                "id_probabilidad" => "required",
                "id_ocurrenciap" => "required",
                "id_potencialapertura" => "required",
                "id_potencialcrecimiento" => "required",
                "id_mejoracliente" => "required",
                "id_mejorasgc" => "required",
                "id_mejorareputacion" => "required",
                "id_potencialcosto" => "required",


            ]);
            $cal_proba=(ri_o_probabilidad::where("id_probabilidad",$request->get("id_probabilidad"))->get())[0]->calificacion;
            $cal_ocurr=(ri_o_ocurrenciasp::where("id_ocurrenciap",$request->get("id_ocurrenciap"))->get())[0]->calificacion;
            $cal_pot_a=(ri_o_potencialapertura::where("id_potencialapertura",$request->get("id_potencialapertura"))->get())[0]->calificacion;
            $cal_pot_c=(ri_o_potencialcrecimiento::where("id_potencialcrecimiento",$request->get("id_potencialcrecimiento"))->get())[0]->calificacion;
            $calificacion_probabilidad=($cal_proba>$cal_ocurr&&$cal_proba>$cal_pot_a&&$cal_proba>$cal_pot_c)?$cal_proba:(($cal_ocurr>$cal_pot_a&&$cal_ocurr>$cal_pot_c)?$cal_ocurr:(($cal_pot_a>$cal_pot_c)?$cal_pot_a:$cal_pot_c));

          //  dd($calificacion_probabilidad);
            $cal_mejcl=(ri_o_mejoracliente::where("id_mejoracliente",$request->get("id_mejoracliente"))->get())[0]->calificacion;
            $cal_mejsgc=(ri_o_mejorasgc::where("id_mejorasgc",$request->get("id_mejorasgc"))->get())[0]->calificacion;
            $cal_mejrep=(ri_o_mejorareputacion::where("id_mejorareputacion",$request->get("id_mejorareputacion"))->get())[0]->calificacion;
            $cal_potcos=(ri_o_potencialcosto::where("id_potencialcosto",$request->get("id_potencialcosto"))->get())[0]->calificacion;
            $calificiacion_beneficio=($cal_mejcl>$cal_mejsgc&&$cal_mejcl>$cal_mejrep&&$cal_mejcl>$cal_potcos)?$cal_mejcl:($cal_mejsgc>$cal_mejrep&&$cal_mejsgc>$cal_potcos)?$cal_mejsgc:($cal_mejrep>$cal_potcos)?$cal_mejrep:$cal_potcos;

            $oportunidad = array(
                "id_probabilidad" => $request->get("id_probabilidad"),
                "id_ocurrenciap" =>$request->get("id_ocurrenciap"),
                "id_potencialapertura" => $request->get("id_potencialapertura"),
                "id_potencialcrecimiento" => $request->get("id_potencialcrecimiento"),
                "calificacion" => $calificacion_probabilidad,
                "id_mejoracliente" => $request->get("id_mejoracliente"),
                "id_mejorasgc" => $request->get("id_mejorasgc"),
                "id_mejorareputacion" =>$request->get( "id_mejorareputacion"),
                "id_potencialcosto" => $request->get("id_potencialcosto"),
                "calif_beneficio" => $calificiacion_beneficio,
                "factor_oportunidad"=>($calificiacion_beneficio*$calificacion_probabilidad),

            );

        }

        ri_reg_oportunidad::find($id)->update($oportunidad);
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
        ri_reg_oportunidad::destroy($id);
        return back();
    }
    public function addFile(ri_o_planseguimiento $id, Request $request)
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
